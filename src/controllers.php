<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

//Request::setTrustedProxies(array('127.0.0.1'));

$app->get('/', function () use ($app) {
    return $app['twig']->render('index.html.twig', array());
})
->bind('homepage');

//Pages de blog
$app->get('/blog', function () use ($app) {
    return $app['twig']->render('blog.html.twig', array());
})
->bind('blog');

$app->get('/blog/{indice}', function ($indice) use ($app) {
    return $app['twig']->render('blog_slug.html.twig', array("indice" => $indice));
})
->bind('blog_slug');
//Pages d'admin' 
$app->get('/admin', function () use ($app) {
    return $app['twig']->render('admin.html.twig', array());
})
->bind('admin');

$app->get('/admin/blog', function () use ($app) {
    return $app['twig']->render('admin_blog.html.twig', array());
})
->bind('admin_blog');

$app->get('/admin/blog/edit/{slug}', function ($slug) use ($app) {
    return $app['twig']->render('admin_blog_edit.html.twig', array("slug" => $slug));
})
->bind('admin_blog_edit');

//

$app->error(function (\Exception $e, Request $request, $code) use ($app) {
    if ($app['debug']) {
        return;
    }

    // 404.html, or 40x.html, or 4xx.html, or error.html
    $templates = array(
        'errors/'.$code.'.html.twig',
        'errors/'.substr($code, 0, 2).'x.html.twig',
        'errors/'.substr($code, 0, 1).'xx.html.twig',
        'errors/default.html.twig',
    );

    return new Response($app['twig']->resolveTemplate($templates)->render(array('code' => $code)), $code);
});
