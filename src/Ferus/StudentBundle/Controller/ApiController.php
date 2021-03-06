<?php
namespace Ferus\StudentBundle\Controller;


use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations\Get;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ApiController extends Controller
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * Récupérer un étudiant.
     * Si le résultat de la requête n'est pas unique (aucun résultat ou plusieurs) une erreur est retournée.
     *
     * Il est possible d'utiliser le nom ET le prenom en les sepérant par des espaces.
     * Il est possible de n'indiquer qu'une partie de la chaine. Exemple : 'nico k'
     *
     * @ApiDoc(
     *      section="Etudiants",
     *      requirements={
     *          {
     *              "name"="query",
     *              "dataType"="string|integer",
     *              "description"="Id, nom ou prénom de l'étudiant"
     *          }
     *      },
     *      description="Récupérer un étudiant"
     * )
     */
    public function getStudentAction($query){

        $students = $this->em->getRepository('FerusStudentBundle:Student')->search($query);

        if(count($students) == 0)
            throw new HttpException(404, 'Aucun résultat pour cette requête.');

        if(count($students) != 1)
            throw new HttpException(400, 'Cette requête ne correspond pas à un résultat unique.');

        return $students[0];
    }

    /**
     * Rechercher des étudiants.
     *
     * Il est possible d'utiliser le nom ET le prenom en les sepérant par des espaces.
     * Il est possible de n'indiquer qu'une partie de la chaine. Exemple : 'nico k'
     *
     * @ApiDoc(
     *      section="Etudiants",
     *      requirements={
     *          {
     *              "name"="query",
     *              "dataType"="string|integer",
     *              "description"="Id, nom ou prénom de l'étudiant"
     *          }
     *      },
     *      description="Rechercher des étudiants"
     * )
     * @Get()
     */
    public function searchStudentsAction($query){

        $students = $this->em->getRepository('FerusStudentBundle:Student')->search($query);
        return $students;
    }

    /**
     * Récupérer tous les étudiants
     *
     * @ApiDoc(
     *      section="Etudiants"
     * )
     */
    public function getStudentsAction()
    {
        $students = $this->em->getRepository('FerusStudentBundle:Student')->findAll();
        return $students;
    }
} 