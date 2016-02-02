<?php
/**
 * @Author: gicque_p
 * @Date:   2015-12-27 15:44:57
 * @Last Modified by:   gicque_p
 * @Last Modified time: 2015-12-27 16:01:08
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
            ->add('members', "text", array(
                'label' => "Nom des membres",
                'attr' => array('class' => "form-control", 'placeholder' => "Membres")
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Bound\CoreBundle\Entity\Crew'
        ));
    }

    public function getName() {
        return 'bound_corebundle_crew_type';
    }

}
