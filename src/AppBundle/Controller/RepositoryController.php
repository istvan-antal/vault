<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Repository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Repository controller.
 *
 * @Route("admin/repositories")
 */
class RepositoryController extends Controller
{
    /**
     * Lists all repository entities.
     *
     * @Route("/", name="admin_repositories_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $repositories = $em->getRepository('AppBundle:Repository')->findAll();

        return $this->render('repository/index.html.twig', array(
            'repositories' => $repositories,
        ));
    }

    /**
     * Creates a new repository entity.
     *
     * @Route("/new", name="admin_repositories_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $repository = new Repository();
        $form = $this->createForm('AppBundle\Form\RepositoryType', $repository);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($repository);
            $em->flush();
            
            mkdir('../data/store/'.$repository->getName(), 0777);
            chmod('../data/store/'.$repository->getName(), 0777);

            return $this->redirectToRoute('admin_repositories_show', array('id' => $repository->getId()));
        }

        return $this->render('repository/new.html.twig', array(
            'repository' => $repository,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a repository entity.
     *
     * @Route("/{id}", name="admin_repositories_show")
     * @Method("GET")
     */
    public function showAction(Repository $repository)
    {
        $deleteForm = $this->createDeleteForm($repository);

        return $this->render('repository/show.html.twig', array(
            'repository' => $repository,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing repository entity.
     *
     * @Route("/{id}/edit", name="admin_repositories_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Repository $repository)
    {
        $deleteForm = $this->createDeleteForm($repository);
        $editForm = $this->createForm('AppBundle\Form\RepositoryType', $repository);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_repositories_edit', array('id' => $repository->getId()));
        }

        return $this->render('repository/edit.html.twig', array(
            'repository' => $repository,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a repository entity.
     *
     * @Route("/{id}", name="admin_repositories_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Repository $repository)
    {
        $form = $this->createDeleteForm($repository);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($repository);
            $em->flush();
        }

        return $this->redirectToRoute('admin_repositories_index');
    }

    /**
     * Creates a form to delete a repository entity.
     *
     * @param Repository $repository The repository entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Repository $repository)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_repositories_delete', array('id' => $repository->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
