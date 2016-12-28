<?php
declare (strict_types = 1);

namespace Tests\Traits\OpenGraph\Objects;

use DateTime;
use Rugaard\MetaScraper\Traits\OpenGraph\Objects\Book;

/**
 * Class AbstractOpenGraphObjectTestCase.
 */
class BookTest extends AbstractOpenGraphObjectTestCase
{
    /**
     * Book instance
     *
     * @var \Rugaard\MetaScraper\Traits\OpenGraph\Objects\Book|null
     */
    protected $book;

    public function testIsBookInstance()
    {
        $this->assertNotEmpty($this->book);
        $this->assertInstanceOf(Book::class, $this->book);
    }

    /**
     * Test method [getAuthor].
     *
     * @return void
     */
    public function testBookAuthors()
    {
        $authors = $this->book->getAuthor();

        $this->assertNotEmpty($authors);
        $this->assertCount(2, $authors);
        $this->assertEquals([
            'http://example.com/author-1',
            'http://example.com/author-2'
        ], $authors);
    }

    /**
     * Test method [getGenre].
     *
     * @return void
     */
    public function testBookGenres()
    {
        $genres = $this->book->getGenre();

        $this->assertNotEmpty($genres);
        $this->assertCount(2, $genres);
        $this->assertEquals([
            'http://example.com/genre-1',
            'http://example.com/genre-2'
        ], $genres);
    }

    /**
     * Test method [getInitialReleaseDate].
     *
     * @return void
     */
    public function testBookInitialReleaseDate()
    {
        $initReleaseDate = $this->book->getInitialReleaseDate();

        $this->assertNotEmpty($initReleaseDate);
        $this->assertInstanceOf(DateTime::class, $initReleaseDate);
        $this->assertEquals('2017-01-01T00:00:00+00:00', $initReleaseDate->format(DATE_W3C));
    }

    /**
     * Test method [getIsbn].
     *
     * @return void
     */
    public function testBookIsbn()
    {
        $isbn = $this->book->getIsbn();

        $this->assertNotEmpty($isbn);
        $this->assertEquals(13, strlen($isbn));
        $this->assertEquals('1234567890000', $isbn);
    }

    /**
     * Test method [getLanguage].
     *
     * @return void
     */
    public function testBookLanguage()
    {
        $language = $this->book->getLanguage();

        $this->assertNotEmpty($language);
        $this->assertCount(1, $language);
        $this->assertEquals(['en_GB'], $language);
    }

    /**
     * Test method [getPageCount].
     *
     * @return void
     */
    public function testBookPageCount()
    {
        $pageCount = $this->book->getPageCount();

        $this->assertNotEmpty($pageCount);
        $this->assertInternalType('int', $pageCount);
        $this->assertEquals(287, $pageCount);
    }

    /**
     * Test method [getRating].
     *
     * @return void
     */
    public function testBookRating()
    {
        $rating = $this->book->getRating();

        $this->assertNotEmpty($rating);
        $this->assertArrayHasKey('value', $rating);
        $this->assertArrayHasKey('scale', $rating);
        $this->assertArraySubset([
            'value' => 0.78,
            'scale' => 1
        ], $rating);
    }

    /**
     * Test method [getReleaseDate].
     *
     * @return void
     */
    public function testBookReleaseDate()
    {
        $releaseDate = $this->book->getReleaseDate();

        $this->assertNotEmpty($releaseDate);
        $this->assertInstanceOf(DateTime::class, $releaseDate);
        $this->assertEquals('2017-01-01T08:00:00+00:00', $releaseDate->format(DATE_W3C));
    }

    /**
     * Test method [getSample].
     *
     * @return void
     */
    public function testBookSample()
    {
        $sample = $this->book->getSample();

        $this->assertNotEmpty($sample);
        $this->assertNotFalse(filter_var($sample, FILTER_VALIDATE_URL));
        $this->assertEquals('http://example.com/book-sample', $sample);
    }

    /**
     * Prepare test case.
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $data = $this->trait->getOpenGraph();

        $this->book = array_key_exists('books', $data['objects']) ? $data['objects']['books'] : null;
    }

    /**
     * Get a mocked response containing valid <meta> tags.
     *
     * @return string
     */
    protected function getMockedResponse() : string
    {
        return <<<HTML
<html><head>
    <title>Mocked response</title>
    <meta property="books:author" content="http://example.com/author-1">
    <meta property="books:author" content="http://example.com/author-2">
    <meta property="books:genre" content="http://example.com/genre-1">
    <meta property="books:genre" content="http://example.com/genre-2">
    <meta property="books:initial_release_date" content="2017-01-01T00:00:00+00:00">
    <meta property="books:isbn" content="1234567890000">
    <meta property="books:language:locale" content="en_GB">
    <meta property="books:page_count" content="287">
    <meta property="books:rating:value" content="0.78">
    <meta property="books:rating:scale" content="1">
    <meta property="books:release_date" content="2017-01-01T08:00:00+00:00">
    <meta property="books:sample" content="http://example.com/book-sample">
</head><body></body></html>
HTML;
    }
}