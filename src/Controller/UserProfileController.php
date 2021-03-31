<?php


namespace App\Controller;


use App\Entity\User;
use App\Entity\UserProfile;
use App\Form\ProfileFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserProfileController extends AbstractController
{
    /**
     * @Route("/register/profile", name="userProfile_profile")
     */
    public function registerProfile(Request $request, EntityManagerInterface $entityManager): Response
    {
        $userProfile = new UserProfile();
        $userProfileForm = $this->createForm(ProfileFormType::class, $userProfile);
        $userProfileForm->handleRequest($request);

        if ($userProfileForm->isSubmitted() and $userProfileForm->isValid()){

            /** @var User $user */
            $user = $this->getUser();

            $userProfile->setUser($user);

            $entityManager->persist($userProfile);
            $entityManager->flush();
        }


        return $this->render('profile/profile.html.twig', [
            'userProfileForm' => $userProfileForm->createView()
        ]);
    }
}