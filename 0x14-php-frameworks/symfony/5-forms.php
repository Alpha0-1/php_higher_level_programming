<?php
/**
 * Symfony Forms Example
 * 
 * Demonstrates form creation, validation, and handling.
 */

namespace App\Form;

use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Product Name',
                'attr' => ['class' => 'form-control']
            ])
            ->add('price', NumberType::class, [
                'scale' => 2,
                'attr' => ['min' => 0, 'step' => '0.01']
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Create Product',
                'attr' => ['class' => 'btn btn-primary']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}

// Controller example:
/*
public function new(Request $request)
{
    $product = new Product();
    $form = $this->createForm(ProductType::class, $product);
    
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($product);
        $entityManager->flush();
        
        return $this->redirectToRoute('product_index');
    }
    
    return $this->render('product/new.html.twig', [
        'form' => $form->createView(),
    ]);
}
*/

echo "Form examples. Key features:\n";
echo "- Form classes define fields and validation\n";
echo "- Data binding to entities\n";
echo "- CSRF protection built-in\n";
echo "- Form theming and customization\n";
?>
