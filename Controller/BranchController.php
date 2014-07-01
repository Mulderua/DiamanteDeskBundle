<?php
/*
 * Copyright (c) 2014 Eltrino LLC (http://eltrino.com)
 *
 * Licensed under the Open Software License (OSL 3.0).
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *    http://opensource.org/licenses/osl-3.0.php
 *
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@eltrino.com so we can send you a copy immediately.
 */
namespace Eltrino\DiamanteDeskBundle\Controller;

use Doctrine\Common\Util\ClassUtils;
use Doctrine\Common\Util\Inflector;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Doctrine\ORM\EntityManager;
use Eltrino\DiamanteDeskBundle\Form\Command\BranchCommand;
use Eltrino\DiamanteDeskBundle\Form\CommandFactory;

use Eltrino\DiamanteDeskBundle\Form\Type\BranchType;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Eltrino\DiamanteDeskBundle\Entity\Branch;

use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("branches")
 */
class BranchController extends Controller
{
    /**
     * @Route(
     *      "/{_format}",
     *      name="diamante_branch_list",
     *      requirements={"_format"="html|json"},
     *      defaults={"_format" = "html"}
     * )
     * @Template
     */
    public function listAction()
    {
        return [];
    }

    /**
     * @Route(
     *      "/view/{id}",
     *      name="diamante_branch_view",
     *      requirements={"id"="\d+"}
     * )
     * @Template
     */
    public function viewAction(Branch $branch)
    {
        return [
            'entity' => $branch
        ];
    }

    /**
     * @Route("/create", name="diamante_branch_create")
     * @Template("EltrinoDiamanteDeskBundle:Branch:edit.html.twig")
     */
    public function createAction()
    {
        $command = $this->get('diamante.command_factory')
            ->createEmptyBranchCommand();

        try {
            $result = $this->edit($command, function ($command) {
                $this->get('diamante.branch.service')
                    ->createBranch(
                        $command->name,
                        $command->description,
                        $command->logoFile,
                        $command->tags
                    );
            });
        } catch(\Exception $e) {
            $this->addErrorMessage($e->getMessage());
            return $this->redirect(
                $this->generateUrl(
                    'diamante_branch_create'
                )
            );
        }
        return $result;
    }

    /**
     * @Route(
     *      "/update/{id}",
     *      name="diamante_branch_update",
     *      requirements={"id"="\d+"}
     * )
     * @Template("EltrinoDiamanteDeskBundle:Branch:edit.html.twig")
     *
     * @param Branch $branch
     * @return array
     */
    public function updateAction(Branch $branch)
    {
        $command = $this->get('diamante.command_factory')
            ->createBranchCommand($branch);

        try {
            $result = $this->edit($command, function ($command) use ($branch) {
                $this->get('diamante.branch.service')
                    ->updateBranch(
                        $branch->getId(),
                        $command->name,
                        $command->description,
                        $command->logoFile,
                        $command->tags
                    );
            }, $branch);
        } catch(\Exception $e) {
            $this->addErrorMessage($e->getMessage());
            return $this->redirect(
                $this->generateUrl(
                    'diamante_branch_update',
                    array(
                        'id' => $branch->getId()
                    )
                )
            );
        }

        return $result;
    }

    /**
     * @param BranchCommand $command
     * @param $callback
     * @return array
     */
    private function edit(BranchCommand $command, $callback)
    {
        $response = null;
        $form = $this->createForm(new BranchType(), $command);
        try {
            $this->handle($form);
            $branchId = $callback($command);
            $this->addSuccessMessage('Branch saved');
            $response = $this->getSuccessSaveResponse($branchId);
        } catch (\LogicException $e) {
            $response = array('form' => $form->createView());
        }
        return $response;
    }

    /**
     * @Route(
     *      "/delete/{id}",
     *      name="diamante_branch_delete",
     *      requirements={"id"="\d+"}
     * )
     *
     * @param Branch $branch
     * @return Response
     */
    public function deleteAction(Branch $branch)
    {
        $this->get('diamante.branch.service')
            ->deleteBranch($branch);

        return new Response(null, 204, array(
            'Content-Type' => $this->getRequest()->getMimeType('json')
        ));
    }

    /**
     * @param Form $form
     * @throws \LogicException
     * @throws \RuntimeException
     */
    private function handle(Form $form)
    {
        if (false === $this->getRequest()->isMethod('POST')) {
            throw new \LogicException('Form can be supported only via POST method');
        }

        $form->handleRequest($this->getRequest());

        if (false === $form->isValid()) {
            throw new \RuntimeException('Form is not valid');
        }
    }

    /**
     * @param $message
     */
    private function addSuccessMessage($message)
    {
        $this->get('session')->getFlashBag()->add(
            'success',
            $this->get('translator')->trans($message)
        );
    }

    /**
     * @param $message
     */
    private function addErrorMessage($message)
    {
        $this->get('session')->getFlashBag()->add(
            'error',
            $this->get('translator')->trans($message)
        );
    }

    /**
     * @param int $branchId
     * @return mixed
     */
    private function getSuccessSaveResponse($branchId)
    {
        return $this->get('oro_ui.router')->actionRedirect(
            array(
                'route' => 'diamante_branch_update',
                'parameters' => array('id' => $branchId),
            ),
            array(
                'route' => 'diamante_branch_view',
                'parameters' => array('id' => $branchId)
            )
        );
    }
}
