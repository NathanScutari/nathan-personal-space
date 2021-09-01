<?php

namespace App\Controller;

use App\Entity\Test;
use App\Repository\TestRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/test', name: 'test')]
class TestController extends AbstractController
{
    public const PAGE_NAME = "COUNT_TEST";

    public function __construct(
        protected TestRepository $testRepository,
        protected EntityManagerInterface $em,
    ) {
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    #[Route('/', name: '')]
    public function index(): Response
    {
        $test = $this->testRepository->findByPageName(self::PAGE_NAME);
        if (is_null($test)) {
            $test = new Test();
            $test->setPage(self::PAGE_NAME);
            $test->setCount(0);
        }
        $test->setCount($test->getCount() + 1);
        $this->em->persist($test);
        $this->em->flush($test);

        return $this->render('test/index.html.twig', [
            'controller_name' => 'TestController',
            'pageCount' => $test->getCount(),
        ]);
    }

    /**
     * @throws ORMException
     */
    #[Route('/reset', name: '_reset')]
    public function reset(): Response
    {
        $test = $this->testRepository->findByPageName(self::PAGE_NAME);
        if (is_null($test)) {
            $test = new Test();
            $test->setPage(self::PAGE_NAME);
        }
        $test->setCount(0);
        $this->em->persist($test);
        $this->em->flush($test);


        return $this->redirectToRoute('test');
    }
}
