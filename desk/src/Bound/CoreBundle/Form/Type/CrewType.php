<?php
/**
 * @Author: gicque_p
 * @Date:   2015-12-27 15:44:57
 * @Last Modified by:   Kafei59
 * @Last Modified time: 2016-03-06 16:30:38
 */

namespace Bound\CoreBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CrewType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('title', "text", array(
                'label' => "Titre de l'idée",
                'attr' => array('class' => "form-control", 'placeholder' => "Titre")
            ))
            ->add('members', "collection", array(
                'label' => "Nom des membres",
                'attr' => array('class' => "form-control", 'placeholder' => "Membres")
            ))
            ->add('submit', "submit")
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Bound\CoreBundle\Entity\Crew',
            'csrf_protection'   => false
        ));
    }

    public function getName() {
        return '';
    }

}
