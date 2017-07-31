<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Repository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Repository controller.
 *
 * @Route("api/store")
 */
class RepositoryApiController extends Controller {

    /**
     * Creates a new repository entity.
     *
     * @Route("/{name}/{path}", name="api_upload_artifact", requirements={"path": ".+"})
     * @Method("POST")
     */
    public function uploadAction(string $name, string $path, Request $request) {
        $em = $this->getDoctrine()->getManager();
        $repositories = $em->getRepository('AppBundle:Repository');
        
        $repository = $repositories->findOneBy([ 'name' => $name ]);

        if (!$repository) {
            return new Response('Not found', 404);
        }
        
        $file = $request->files->get('file');
        /* @var $file \Symfony\Component\HttpFoundation\File\UploadedFile */
        $destination = "../data/store/$name/$path";
        $destinationDirectory = dirname($destination);
        
        mkdir($destinationDirectory, 0777, true);
        $file->move($destinationDirectory, basename($destination));
        
        
        return new Response('Uploaded');
    }

}
