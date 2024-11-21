<?php

namespace App\Controller;

use App\Entity\GentlePuppy;
use App\Entity\Student;
use App\Form\GentlePuppyType;
use App\Form\StudentType;
use App\Repository\GentlePuppyRepository;
use App\Repository\StudentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class StudentController extends AbstractController
{
    #[Route('/student', name: 'app_student', methods: ['GET'])]
    public function index(StudentRepository $studentRepository, $entityManager): Response
    {
        return $this->render('student/index.html.twig', [
            'students' => $studentRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_Student_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $Student = new Student();
        $form = $this->createForm(StudentType::class, $Student);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($Student);
            $entityManager->flush();

            return $this->redirectToRoute('app_student', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('gentle_puppy/new.html.twig', [
            'gentle_puppy' => $Student,
            'form' => $form,
        ]);
    }

    #[Route('/student/{id}', name: 'app_show_student', methods: ['GET'])]
    public function showStudent(Student $Student): Response
    {
        return $this->render('student/show-student.html.twig', [
            'student' => $Student,
        ]);
    }
}