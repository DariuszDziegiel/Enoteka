<?php

namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Response;


class MainteranceController extends Controller
{
    /**
     * @Route("/cache_clear", name="cache_clear")
     */
    public function clearCacheAction() {

        /*
        $kernel = $this->get('kernel');
        $app = new Application($kernel);
        $app->setAutoExit(false);
        $options = [
            'command' => 'cache:clear',
            '--env'   => 'prod'
        ];
        $app->run(new ArrayInput($options));*/
        
        $fs = new Filesystem();
        $fs->remove($this->getParameter('kernel.cache_dir'));

        //$cacheWarmer  = $this->get('kernel.class_cache.cache_warmer');
        //$cacheWarmer->warmUp($this->getParameter('kernel.cache_dir'));
        exec('php bin/console cache:warmup --env=prod');


        return new Response('!!! Cache Cleared !!!');
    }

}
