<?php 
  namespace Foxx\Library\Core\Model;
  use Foxx\Library\Core\Model\Loan;
  use Foxx\Library\Core\Enums\LoanGetBy;
  use Foxx\Library\Core\Exception\BookException;

  /**
   * Book
   * 
   * Is a model class that represents a book in the library.
   * 
   * @package Foxx\Library\Core\Model
   * @author Foxx Azalea Pinkerton
   * @implements \JsonSerializable
   */
  class Book implements \JsonSerializable {
    
    /**
     * Constructor method for Book
     * 
     * Constructor method for the book model class.
     * 
     * @param string $title Title of the book
     * @param string $author Author of the book
     * @param string[] $genres The genres the book falls under
     * @param string $description A small blurb about the book, taken from Wikipedia or GoodReads
     * @param ?Loan[] $loans An array of all loans taken out on the book
     * @param ?float $rating The rating for the book
     * @param ?int $ratings The number of ratings for the book
     * @param ?string $id Unique ID generated for the book
     */
    public function __construct(
      private string $title, 
      private string $author, 
      private array $genres, 
      private string $description, 
      private ?array $loan = array(), 
      private ?string $cover = null, 
      private ?float $rating = 0, 
      private ?int $ratings = 0, 
      private ?string $id = "" 
    ) {
      $cover = $cover ?? "/img/covers/default.jpg";
      if ($id == "") { $id = uniqid("book_"); }
      else {$id = $id; }
    }

    /**
     * Json serialiser
     * 
     * Tells json_encode how to serialise the Book object.
     * 
     * @return array Array of book information for the JSON output
     */
    public function jsonSerialize(): array {
      return [
        "title" => $this->title,
        "author" => $this->author,
        "genres" => $this->genres,
        "description" => $this->description,
        "loan" => $this->loan,
        "cover" => $this->cover,
        "rating" => $this->rating,
        "ratings" => $this->ratings,
        "id" => $this->id
      ];      
    }


    /**
     * Gets or sets the books title.
     * 
     * Get or set the books title as needed.
     * With no arguments, this is a getter.
     * With one argument, this is a setter and the books title get's set to the argument.
     * 
     * @param ?string $title The books title.
     * @return string|self
     * @author Command_String#6538
     */
    public function title(?string $title = null): string|self {
      if (is_null($title)) {
        return $this->title;
      } else {
        $this->title = $title;
        return $this;
      }
    }

    /**
     * Gets or sets the books author.
     * 
     * Get or set the books author as needed.
     * With no arguments, this is a getter.
     * With one argument, this is a setter and the books author get's set to the argument.
     * 
     * @param ?string $author The name of the book author.
     * @return string|self
     * @author Command_String#6538
     */
    public function author(?string $author = null): string|self {
      if (is_null($author)) {
        return $this->author;
      } else {
        $this->author = $author;
        return $this;
      }
    }

    /**
     * Gets or sets the books genres.
     * 
     * Gets or sets a list of genres the book falls under.
     * With no arguments, this is a getter.
     * With one argument, this is a setter and the books genres get's set to the argument.
     * 
     * @param ?string[] $genres A list of genres the book falls under.
     * @return string[]|self
     * @author Command_String#6538
     */
    public function genres(?array $genres = null): array|self {
      if (is_null($genres)) {
        return $this->genres;
      } else {
        $this->genres = $genres;
        return $this;
      }
    }

    /**
     * Gets or sets the books description.
     * 
     * Get or set the description of the book as needed.
     * With no arguments, this is a getter.
     * With one argument, this is a setter and the books description get's set to the argument.
     * 
     * @param ?string $description A small blurb about the book, typically taken from Wikipedia or GoodReads
     * @return string|self
     * @author Command_String#6538
     */
    public function loan(?Loan $loan = null): array|self {
      if (is_null($loan)) {
        return $this->loan;
      } else {
        $this->loan = $loan;
        return $this;
      }
    }

    /**
     * Gets or sets the books description.
     * 
     * Get or set the description of the book as needed.
     * With no arguments, this is a getter.
     * With one argument, this is a setter and the books description get's set to the argument.
     * 
     * @param ?string $description A small blurb about the book, typically taken from Wikipedia or GoodReads
     * @return string|self
     * @author Command_String#6538
     */
    public function description(?string $description = null): string|self {
      if (is_null($description)) {
        return $this->description;
      } else {
        $this->description = $description;
        return $this;
      }
    }

    /**
     * Gets or sets the books rating.
     * 
     * Get or set the rating of the book as needed.
     * With no arguments, this is a getter.
     * With one argument, this is a setter and the books rating get's set to the argument.
     * 
     * @param ?float $rating A users rating of the book, between 0 and 5 stars
     * @return float|self
     * @author Command_String#6538
     */
    public function rating(?float $rating = null): float|self {
      if (is_null($rating)) {
        return $this->rating;
      } else {
        $this->rating = $rating;
        return $this;
      }
    }

    /**
     * Gets or sets the number of ratings for the book.
     * 
     * Get or set the number of ratings for the book as needed.
     * With no arguments, this is a getter.
     * With one argument, this is a setter and the number of ratings get's set to the argument.
     * 
     * @param ?int $ratings Number of ratings for the book.
     * @return int|self
     * @author Command_String#6538
     */
    public function ratings(?int $ratings = null): int|self {
      if (is_null($ratings)) {
        return $this->ratings;
      } else {
        $this->ratings = $ratings;
        return $this;
      }
    }

    /**
     * Gets or sets the books cover.
     * 
     * Get or set the books cover URL as needed.
     * With no arguments, this is a getter.
     * With one argument, this is a setter and the books cover get's set to the argument.
     * 
     * @param ?string $cover A url pointing to one of the books covers
     * @return string|self
     * @author Command_String#6538
     */
    public function cover(?string $cover = null): string|self {
      if (is_null($cover)) {
        return $this->cover;
      } else {
        $this->cover = $cover;
        return $this;
      }
    }

    /**
     * Gets or sets the books UUID.
     * 
     * Get or set the books UUID as needed.
     * With no arguments, this is a getter.
     * With one argument, this is a setter and the books UUID get's set to the argument.
     * 
     * @param ?string $id A unique identifier for the book
     * @return string|self
     * @author Command_String#6538
     */
    public function id(?string $id = null): string|self
    {
      if (is_null($id)) {
        return $this->id;
      } else {
        $this->id = $id;
        return $this;
      }
    }

    // Other methods

    /**
     * Checks if a book is loaned out or not.
     * 
     * Function to check if a book is loaned out or not.
     * 
     * @return boolean Returns true if the book is loaned out and false if it isn't.
     */
    function isLoaned(): bool {
      if (count($this->loan) == 0) return false;

      /**
       * @var Loan $lastLoan
       */
      $lastLoan = end($this->loan);
      return !empty($lastLoan) ? !$lastLoan->get(LoanGetBy::RETURNED) : false;
    }

    /**
     * adds a loan to the book
     * 
     * Adds a loan to the book by adding it to the array of existing loans.
     * 
     * @param Loan $loan The loan to add to the book
     * @return boolean Returns true if the loan was added and false if it is loaned out already.
     * @throws BookException if book is loaned currently
     */
    public function addLoan(Loan $loan) {
      if (!$this->isLoaned()) { // Book not loaned -> add loan
        $this->loan[] = $loan;
        return true;
      } else { // Book loaned -> throw error
        return false;
        throw new BookException(BookException::LOANED, BookException::LOANED_CODE);
      }
    }

    /**
     * Adds a rating to the book
     * 
     * @param int $rating
     * @return float The new rating
     */
    public function addRating(int $rating) {
      $old = $this->rating;
      $amount = $this->ratings;

      $this->rating = ($old * $amount + $rating) / ($amount + 1);
      $this->ratings++;

      return $this->rating;
    }

    public function addCover($cover) {
      // TODO: Add cover to book
    }

    /**
     * makes card for the book to use in the homepage
     * 
     * Helper function to make a card for the book to use
     * 
     * @return string HTML <div> with book info
     * @see \Foxx\Library\Action\HomeAction
     */
    public function makeCard(): string {
      $title = $this->title;
      $author = $this->author;
      $description = $this->description;
      $cover = $this->cover;
      $rating = round($this->rating, 1);
      $id = $this->id;


      $card = '<div class="card">';
      $card .= '<img class="card-img-top" src="' . $cover . '" alt="' . $title . '\'s Cover" />';
      $card .= '<div class="card-body">'; 
      $card .= '<h4 class="card-title">' . $title . ' by ' . $author . '</h4>';
      $card .= '<p class="card-text">' . $description . '</p>';
      $card .= '</div>';
      $card .= '<div class="card-footer">';

      // star rating
      $card .= '<div class="star-rating mb-2">';
      
      for ($i = 1; $i <= 5; $i++) {
        if ($i <= $rating) {
          $card .= '<span class="fa fa-star" data-rating="' . $i . '"></span>';
        } else {
          $card .= '<span class="fa fa-star-o" data-rating="' . $i . '"></span>';
        }
      }

      $card .= '</div>';
      $card .= '<a href="/book/'. $id . '" class="btn btn-primary">View Details</a>';
      $card .= '</div>';
      $card .= '</div>';

      return $card;
    }

    public function genreList(): string {
      $genres = $this->genres;
      $list = '';
      foreach ($genres as $genre) {
        $list .= '<li style="font-size: 26px;">'. $genre . '</li>';
      }
      return $list;
    }

  }