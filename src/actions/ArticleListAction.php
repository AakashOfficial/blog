<?php
namespace sagebind\blog\actions;

use Icicle\Http\Message\{BasicResponse, Request};
use Icicle\Stream\MemorySink;

class ArticleListAction extends Action
{
    public function handle(Request $request, array $args): \Generator
    {
        $html = $this->app->getRenderer()->render('articleList', [
            'articles' => $this->app->getArticleStore()->getIterator(),
        ]);

        $sink = new MemorySink();
        yield from $sink->end($html);

        return new BasicResponse(200, [
            'Content-Type' => 'text/html',
            'Content-Length' => $sink->getLength(),
        ], $sink);
    }
}