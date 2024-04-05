<?php

namespace Gutenberg\Parser;

use Gutenberg\Models\Author;
use Gutenberg\Models\Compiler;
use Gutenberg\Models\GutenbergBook;
use Symfony\Component\DomCrawler\Crawler;

include "./vendor/autoload.php";
class GutenbergRDFParser
{

    public function __invoke(int $folder) : GutenbergBook
    {
        $id = $folder;
        $book = new GutenbergBook();
        $book->id = $id;
        $doc = new Crawler(file_get_contents("./cache/epub/$id/pg$id.rdf"));
        $doc->registerNamespace('marcrel', "http://id.loc.gov/vocabulary/relators/");
        $doc->registerNamespace('dcterms', "http://purl.org/dc/terms/");
        $doc->registerNamespace('rdfs', "http://www.w3.org/2000/01/rdf-schema#");
        $doc->registerNamespace('rdf', "http://www.w3.org/1999/02/22-rdf-syntax-ns#");
        $doc->registerNamespace('pgterms', "http://www.gutenberg.org/2009/pgterms/");
        $doc->registerNamespace('cc', "http://web.resource.org/cc/");
        $doc->registerNamespace('dcam', "http://purl.org/dc/dcam/");
        $book->title = $doc->filterXPath("//dcterms:title")->text();
        $book->authors = $this->getAuthors($doc);
        $book->compilers = $this->getCompilers($doc);
        $book->credits = $doc->filterXPath("//pgterms:marc508")->text("") ;
        $book->notes = $doc->filterXPath("//rdf:RDF/pgterms:ebook/dcterms:description")->text("");
        $book->language = $doc->filterXPath("//dcterms:language")->text("");
        $book->releaseDate = $doc->filterXPath("//dcterms:issued")->text("");
        $book->contents = $doc->filterXPath("//dcterms:tableOfContents")->text("");
        $book->downloads = $doc->filterXPath("//pgterms:downloads")->text("");
        return $book;
    }

    /**
     * @param Crawler $doc
     * @return array
     */
    public function getAuthors(Crawler $doc): array
    {
        return $doc->filterXPath("//dcterms:creator")->each(function (Crawler $parent): Author {
            $author = new Author();
            $agentAttribute = $parent->filterXPath("node()/pgterms:agent")->attr("rdf:about");
            $matches = [];
            preg_match('((\d+)/(agents)/(\d+))', $agentAttribute, $matches);
            $author->id = $matches[3];
            $author->name = $parent->filterXPath("node()/pgterms:agent/pgterms:name")->text();
            $author->birthDate = $parent->filterXPath("node()/pgterms:agent/pgterms:birthdate")->text();
            $author->deathDate = $parent->filterXPath("node()/pgterms:agent/pgterms:deathdate")->text() ?? "present";
            $author->alias = $parent->filterXPath("node()/pgterms:agent/pgterms:alias")->each(function (Crawler $alias): string {
                return $alias->text();
            });
            return $author;
        });
    }

    private function getCompilers(Crawler $doc) : array
    {
        return $doc->filterXPath("//marcrel:com")->each(function (Crawler $parent): Compiler {
            $compiler = new Compiler();
            $agentAttribute = $parent->filterXPath("node()/pgterms:agent")->attr("rdf:about");
            $matches = [];
            preg_match('((\d+)/(agents)/(\d+))', $agentAttribute, $matches);
            $compiler->id = $matches[3];
            $compiler->name = $parent->filterXPath("node()/pgterms:agent/pgterms:name")->text();
            $compiler->birthDate = $parent->filterXPath("node()/pgterms:agent/pgterms:birthdate")->text();
            $compiler->deathDate = $parent->filterXPath("node()/pgterms:agent/pgterms:deathdate")->text() ?? "present";
            $compiler->alias = $parent->filterXPath("node()/pgterms:agent/pgterms:alias")->each(function (Crawler $alias): string {
                return $alias->text();
            });
            return $compiler;
        });
    }

}