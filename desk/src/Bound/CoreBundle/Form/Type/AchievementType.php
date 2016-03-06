<?php
/**
 * @Author: gicque_p
 * @Date:   2016-02-14 19:13:04
 * @Last Modified by:   Kafei59
 * @Last Modified time: 2016-03-06 16:30:34
 */

namespace Bound\CoreBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Controller\Annotations\RequestParam;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use JMS\Serializer\SerializerBuilder;

class AchievementType extends AbstractType {

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('title', "text", array(
                'label' => "Titre du haut-fait",
                'attr' => array('class' => "form-control", 'placeholder' => "Titre")
            ))
            ->add('content', "textarea", array(
                'label' => "Contenu du haut-fait",
                'attr' => array('class' => "form-control", 'placeholder' => "Contenu")
            ))
            ->add('points', "number", array(
                'label' => "Nombre de points du haut-fait",
                'attr' => array('class' => "form-control", 'placeholder' => "Points")
            ))
            ->add('type', "text", array(
                'label' => "Type du Loader du haut-fait",
                'attr' => array('class' => "form-control", 'placeholder' => "Type")
            ))
            ->add('functionId', "text", array(
                'label' => "ID de la function de check du haut-fait",
                'attr' => array('class' => "form-control", 'placeholder' => "ID Fonction")
            ))
            ->add('submit', "submit")
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Bound\CoreBundle\Entity\Achievement',
            'csrf_protection'   => false
        ));
    }

    public function getName() {
        return '';
    }
}
