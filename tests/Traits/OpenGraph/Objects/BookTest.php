<?php
declare (strict_types = 1);

namespace Tests\Traits\OpenGraph\Objects;

use Rugaard\MetaScraper\Traits\OpenGraph\Objects\Book;

/**
 * Class AbstractOpenGraphObjectTestCase.
 */
class BookTest extends AbstractOpenGraphObjectTestCase
{
    public function testBook()
    {
        $data = $this->trait->getAllByNamespace('books');

        $book = new Book($data);
        var_dump($book);
        die;
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
    <meta property="books:initial_release_date" content="2017-01-01T00:00:00+0000">
    <meta property="books:isbn" content="1234567890">
    <meta property="books:language:locale" content="en_GB">
    <meta property="books:page_count" content="287">
    <meta property="books:rating:value" content="0.78">
    <meta property="books:rating:scale" content="1">
    <meta property="books:release_date" content="2017-01-01T08:00:00+0000">
    <meta property="books:sample" content="http://example.com/book-sample">
</head><body></body></html>
HTML;
    }
}