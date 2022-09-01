<?php

namespace Plugin\ErrorNotify\Form\Type\Admin;

use Plugin\ErrorNotify\Entity\Config;
//フォームタイプ
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Eccube\Form\Type\ToggleSwitchType;
use Plugin\ErrorNotify\Service\ErrorLogService;

class ConfigType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $logLevels = array_flip(ErrorLogService::$monologLevels);
        $builder
        ->add('from_mail', EmailType::class, [
            'constraints' => [
                new NotBlank(),
                new Length(['max' => 255]),
            ],
        ])
        ->add('send_mail', EmailType::class, [
            'constraints' => [
                new NotBlank(),
                new Length(['max' => 255]),
            ],
        ])
        //基本設定のトグルボタンを使いたい。参考のFormTypeをよう確認
        ->add('is_send',ToggleSwitchType::class)
        //セレクト式、 ErrorLogserviceから選択肢持ってくる？
        ->add('send_level',ChoiceType::class,[
                'choices' => array_slice($logLevels,2)
            ],
        )
        //セレクト式、 ErrorLogserviceから選択肢持ってくる？
        ->add('is_record',ToggleSwitchType::class)
        ->add('record_level',ChoiceType::class,[
                'choices' => array_slice($logLevels,2)
            ],
        )
        ->add('record_deduplicated_time',NumberType::class)
        ->add('send_deduplicated_time',NumberType::class)
        ;

    }

    /**z
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Config::class,
        ]);
    }
}
