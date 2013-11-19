<?php

namespace Infotravel\BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;

class ArticleType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('date', 'date')
                ->add('titre', 'text')
                ->add('contenu', 'textarea')
                ->add('auteur', 'text')
                ->add('tag', 'text', array('required' => false))
                ->add('image', new ImageType(), array('required' => false))
                ->add('categories', 'collection', array(
                    'type' => new CategorieType(),
                    'allow_add' => true,
                    'allow_delete' => true,
                ))
//                ->add('tags', 'collection', array(
//                    'type' => new TagsType(),
//                    'allow_add' => true,
//                    'allow_delete' => true,
//                ))
        ;
        $factory = $builder->getFormFactory();

        $builder->addEventListener(
                FormEvents::PRE_SET_DATA, function(FormEvent $event) use ($factory) {
                    $article = $event->getData();

                    if (null === $article) {
                        return;
                    }

                    if (false === $article->getPublication()) {
                        $event->getForm()->add(
                                $factory->createNamed('publication', 'checkbox', null, array('required' => false))
                        );
                    } else { // Sinon, on le supprime
                        $event->getForm()->remove('publication');
                    }
                }
        );
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Infotravel\BlogBundle\Entity\Article'
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'infotravel_blogbundle_article';
    }

}
