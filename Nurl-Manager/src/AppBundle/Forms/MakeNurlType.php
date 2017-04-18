<?php
/**
 * Created by PhpStorm.
 * User: mateo
 * Date: 18/04/2017
 * Time: 15:27
 */

namespace AppBundle\Forms;

use AppBundle\Entity\Nurl;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MakeNurlType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $choices = [];

        foreach($options['tags'] as $tag) {
            $choices[$tag->getTitle()] = $tag->getId();
        }

        $builder->add('title')
            ->add('summary', TextareaType::class)
            ->add('body',  TextareaType::class)
//            ->add('tags', ChoiceType::class, [
//                'choices' => $choices,
//                'multiple' => true,
//                'mapped' => false,
//                'required' => false
//            ])
            ->add('Submit', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Nurl::class,
            'tags' => []
        ]);
    }
}