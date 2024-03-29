<?php
  namespace Foxx\Library\Action\Auth;

  use Psr\Http\Message\ResponseInterface as Response;
  use Psr\Http\Message\ServerRequestInterface as Request;
  use Slim\Views\Twig;

  use Foxx\Library\Core\Enums\GetUsersBy;
  use Foxx\Library\Core\Persistence\UserManager;
  use Foxx\Library\Core\Enums\UserTypes;

  /**
   * LoginAction
   * 
   * Is the action that is called when the user is logging in
   * 
   * @package Foxx\Library\Action\Auth
   * @author Foxx Azalea Pinkerton
   */
  final class LoginAction {
    /**
     * __construct
     * 
     * Is the constructor for the LoginAction
     * 
     * @param Twig $twig The twig renderer
     * @param UserManager $userManager The user manager
     */
    public function __construct(
      private Twig $twig,
      private UserManager $userManager
    ){}

    /**
     * __invoke
     * 
     * Is the function that is called when the action is called
     *
     * @param Request $request The request that is being made
     * @param Response $response The response that is being sent
     * @return Response The response that is being sent
     */
    public function __invoke(Request $request, Response $response): Response {
      if ($request->getMethod() == "GET") { // If the request is a GET request
        return $this->twig->render($response, "Auth/login.twig");
      } else { // If the request is a POST request
        /**
         * @var array $body The body of the request
         */
        $body = $request->getParsedBody();

        /**
         * @var string $email The email that the user is trying to login with
         */
        $email = $body["email"];

        /**
         * @var string $password The password that the user is trying to login with
         */
        $password = $body["password"];

        try { // Try to get the user
          /**
           * @var Foxx\Library\Core\Model\User $user The user that is trying to login
           */
          $user = $this->userManager->GetUsersBy(GetUsersBy::EMAIL, $email)[0];
        } catch (\Exception $e) { // If the user does not exist
          return $this->twig->render($response, "Auth/login.twig", [
            "error" => "Invalid email"
          ]);
        }

        if (!$user->verifyPassword($password)) { // If the password is incorrect
          return $this->twig->render($response, "Auth/login.twig", [
            "error" => "Invalid password"
          ]);
        }

        /**
         * @var Foxx\Library\Core\Enums\UserTypes $accountType The type of account that the user has
         */
        $accountType = $user->userTypes();
        
        /**
         * @var string $session The session that the user is logged in with
         */
        $_SESSION["user"] = $user->id();

        if ($accountType == UserTypes::ADMIN) { // If the user is an admin
          return $response->withHeader("Location", "/admin/dashboard")->withStatus(302);
          die();
        } elseif ($accountType == UserTypes::USER) { // If the user is a user
          return $response->withHeader("Location", "/user/dashboard")->withStatus(302);
          die();
        } else { // debug code
          $body = $request->getParsedBody();
          $body->write(var_dump($accountType));
          return $body;
        }
      }
    }
  }

