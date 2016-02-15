<?php
/**
 * @Author: gicque_p
 * @Date:   2016-02-14 19:13:04
 * @Last Modified by:   gicque_p
 * @Last Modified time: 2016-02-15 14:22:48
 */

namespace Bound\CoreBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AchievementType extends AbstractType {

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
