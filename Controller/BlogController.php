<?php

namespace Bundle\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Query;

class BlogController extends Controller
{
    public function homeAction()
    {
        // entity manager and query builder objects
        $em = $this->get('doctrine.orm.entity_manager');
        
        $qb = new QueryBuilder($em);
        // dql query
        $qb->select('p,c,t')
            ->from('Bundle\BlogBundle\Entity\Post', 'p')
            ->join('p.category', 'c')
            ->join('p.tags', 't')
            ->orderBy('p.date', 'DESC');
        // array of objects
        $posts = $qb->getQuery()->getResult();

        $query = $em->createQuery('SELECT c,p FROM Bundle\BlogBundle\Entity\Category c JOIN c.posts p');
        $categories = $query->getResult();

        $query = $em->createQuery('SELECT t,p FROM Bundle\BlogBundle\Entity\Tag t JOIN t.posts p');
        $tags = $query->getResult();

        return $this->render('BlogBundle:Blog:homepage.twig', array(
            'posts' => $posts,
            'categories' => $categories,
            'tags' => $tags
        ));
    }

    public function postAction($slug)
    {
        // entity manager and query builder objects
        $em = $this->get('doctrine.orm.entity_manager');

        $query = new Query($em);
        $query->setDQL(
            'SELECT p,comments 
                FROM Bundle\BlogBundle\Entity\Post p
                JOIN p.comments comments
                WHERE p.slug = ?1'
        );
        $query->setParameter(1, $slug);
        $posts = $query->getResult();


        return $this->render('BlogBundle:Blog:post.twig', array(
            'post' => $posts[0]
        ));
    }
}
