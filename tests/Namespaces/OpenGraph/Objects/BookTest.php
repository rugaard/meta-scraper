<?php
declare(strict_types=1);

namespace Tests\Namespaces\OpenGraph\Objects;

use DateTime;
use Rugaard\MetaScraper\Exceptions\AttributeNotFoundException;
use Rugaard\MetaScraper\Exceptions\MethodNotFoundException;
use Rugaard\MetaScraper\Namespaces\OpenGraph\Objects\Book;
use Tests\Namespaces\OpenGraph\AbstractOpenGraphTestCase;

/**
 * Class BookTest.
 */
class BookTest extends AbstractOpenGraphTestCase
{
    /**
     * Book instance.
     *
     * @var \Rugaard\MetaScraper\Namespaces\OpenGraph\Objects\Book|null
     */
    protected $book;

    /**
     * Test that object is a Book instance.
     *
     * @return void
     */
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
    public function testAuthorReferences()
    {
        $authors = $this->book->getAuthor();

        $this->assertNotEmpty($authors);
        $this->assertInternalType('array', $authors);
        $this->assertCount(2, $authors);
        $this->assertNotFalse(filter_var($authors[0], FILTER_VALIDATE_URL));
        $this->assertNotFalse(filter_var($authors[1], FILTER_VALIDATE_URL));
        $this->assertEquals([
            'http://example.com/author-1',
            'http://example.com/author-2',
        ], $authors);
    }

    /**
     * Test method [getGender].
     *
     * @return void
     */
    public function testAuthorGender()
    {
        $gender = $this->book->getGender();

        $this->assertNotEmpty($gender);
        $this->assertEquals('male', $gender);
    }

    /**
     * Test method [getBook].
     *
     * @return void
     */
    public function testBookReferences()
    {
        $books = $this->book->getBook();

        $this->assertNotEmpty($books);
        $this->assertInternalType('array', $books);
        $this->assertCount(2, $books);
        $this->assertNotFalse(filter_var($books[0], FILTER_VALIDATE_URL));
        $this->assertNotFalse(filter_var($books[1], FILTER_VALIDATE_URL));
        $this->assertEquals([
            'http://example.com/book-1',
            'http://example.com/book-2',
        ], $books);
    }

    /**
     * Test method [getGenre].
     *
     * @return void
     */
    public function testGenreReferences()
    {
        $genres = $this->book->getGenre();

        $this->assertNotEmpty($genres);
        $this->assertInternalType('array', $genres);
        $this->assertCount(2, $genres);
        $this->assertNotFalse(filter_var($genres[0], FILTER_VALIDATE_URL));
        $this->assertNotFalse(filter_var($genres[1], FILTER_VALIDATE_URL));
        $this->assertEquals([
            'http://example.com/genre-1',
            'http://example.com/genre-2',
        ], $genres);
    }

    /**
     * Test method [getInitialReleaseDate].
     *
     * @return void
     */
    public function testInitialReleaseDate()
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
    public function testIsbn()
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
    public function testLanguage()
    {
        $language = $this->book->getLanguage();

        $this->assertNotEmpty($language);
        $this->assertInternalType('array', $language);
        $this->assertCount(1, $language);
        $this->assertEquals(['en_GB'], $language);
    }

    /**
     * Test method [getPageCount].
     *
     * @return void
     */
    public function testPageCount()
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
    public function testRating()
    {
        $rating = $this->book->getRating();

        $this->assertNotEmpty($rating);
        $this->assertInternalType('array', $rating);
        $this->assertArrayHasKey('value', $rating);
        $this->assertArrayHasKey('scale', $rating);
        $this->assertArraySubset([
            'value' => 0.78,
            'scale' => 1,
        ], $rating);
    }

    /**
     * Test method [getReleaseDate].
     *
     * @return void
     */
    public function testReleaseDate()
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
    public function testSampleUrl()
    {
        $sample = $this->book->getSample();

        $this->assertNotEmpty($sample);
        $this->assertNotFalse(filter_var($sample, FILTER_VALIDATE_URL));
        $this->assertEquals('http://example.com/book-sample', $sample);
    }

    /**
     * Test method [getOfficialSite].
     *
     * @return void
     */
    public function testOfficialSiteUrl()
    {
        $officialSite = $this->book->getOfficialSite();

        $this->assertNotEmpty($officialSite);
        $this->assertNotFalse(filter_var($officialSite, FILTER_VALIDATE_URL));
        $this->assertEquals('http://example.com/official-site', $officialSite);
    }

    /**
     * Test magic [__call] method.
     *
     * @return void
     */
    public function testMagicInvalidGetMethod()
    {
        $this->expectException(MethodNotFoundException::class);
        $this->book->callNoneExistingGetMethod();
    }

    /**
     * Test exception is thrown when trying to retrieve
     * a non-existing attribute.
     *
     * @return void
     */
    public function testMagicInvalidAttribute()
    {
        $this->expectException(AttributeNotFoundException::class);
        $this->book->getNonExistingAttribute();
    }

    /**
     * Prepare test case.
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $this->invokeMethod($this->trait, 'parseOpenGraphObjects', []);

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
    <meta property="books:gender" content="male">
    <meta property="books:book" content="http://example.com/book-1">
    <meta property="books:book" content="http://example.com/book-2">
    <meta property="books:genre" content="http://example.com/genre-1">
    <meta property="books:genre" content="http://example.com/genre-2">
    <meta property="books:canonical_name" content="Drama">
    <meta property="books:initial_release_date" content="2017-01-01T00:00:00+00:00">
    <meta property="books:isbn" content="1234567890000">
    <meta property="books:language:locale" content="en_GB">
    <meta property="books:page_count" content="287">
    <meta property="books:rating:value" content="0.78">
    <meta property="books:rating:scale" content="1">
    <meta property="books:release_date" content="2017-01-01T08:00:00+00:00">
    <meta property="books:sample" content="http://example.com/book-sample">
    <meta property="books:official_site" content="http://example.com/official-site">
</head><body></body></html>
HTML;
    }
}
