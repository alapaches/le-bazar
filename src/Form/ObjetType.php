<?php

namespace App\Form;

use App\Entity\Lieu;
use App\Entity\Objet;
use App\Entity\Piece;
use App\Form\PieceType;
use App\Entity\Categorie;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ObjetType extends AbstractType
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, [
                'attr' => ['class' => 'form-control'],
            ])
        ;
        $builder->addEventListener(FormEvents::PRE_SET_DATA, array($this, 'onPreSetData'));
        $builder->addEventListener(FormEvents::PRE_SUBMIT, array($this, 'onPreSubmit'));
    }

    protected function addElements(FormInterface $form, Piece $piece = null, Categorie $categorie = null) {
        $form->add('piece', EntityType::class, array(
            'required' => true,
            'data' => $piece,
            'placeholder' => 'Choisir une pièce',
            'class' => Piece::class,
            'attr' => ['class' => 'form-control'],
        ));
        $form->add('categorie', EntityType::class, [
            'required' => true,
            'data' => $categorie,
            'placeholder' => 'Choisir une catégorie',
            'class' => Categorie::class,
            'attr' => ['class' => 'form-control'],
        ]);
        
        $lieux = array();
        if ($piece) {
            $repoLieux = $this->em->getRepository(Lieu::class);
            $lieux = $repoLieux->createQueryBuilder("q")
                ->where("q.piece = :pieceId")
                ->setParameter("pieceId", $piece->getId())
                ->getQuery()
                ->getResult()
            ;
        }
        $form->add('lieu', EntityType::class, array(
            'required' => true,
            'placeholder' => 'Selectionner d\'abord une pièce',
            'class' => Lieu::class,
            'attr' => ['class' => 'form-control'],
            'choices' => $lieux
        ));
    }

    function onPreSubmit(FormEvent $event) {
        $form = $event->getForm();
        $data = $event->getData();
        
        $piece = $this->em->getRepository(Piece::class)->find($data['piece']);
        
        $this->addElements($form, $piece);
    }

    function onPreSetData(FormEvent $event) {
        $objet = $event->getData();
        $form = $event->getForm();

        // When you create a new person, the City is always empty
        $piece = $objet->getPiece() ? $objet->getPiece() : null;
        
        $this->addElements($form, $piece);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Objet::class,
        ]);
    }
}
