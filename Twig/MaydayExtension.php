<?php

namespace SensioLabs\Bundle\MaydayBundle\Twig;

use Doctrine\Bundle\DoctrineBundle\Registry;
use SensioLabs\Bundle\MaydayBundle\Repository\UserRepository;
use Twig_Environment;

/**
 * @author Jean-François Simon <contact@jfsimon.fr>
 */
class MaydayExtension extends \Twig_Extension
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var string
     */
    private $reactHost;

    /**
     * @var string
     */
    private $reactPort;

    /**
     * @var \Twig_Environment
     */
    private $environment;

    /**
     * @param Registry $doctrine
     * @param string   $reactHost
     * @param string   $reactPort
     */
    public function __construct(Registry $doctrine, $reactHost, $reactPort)
    {
        $this->userRepository = $doctrine->getRepository('SensioLabsMaydayBundle:User');
        $this->reactHost = $reactHost;
        $this->reactPort = $reactPort;
    }

    /**
     * {@inheritdoc}
     */
    public function initRuntime(Twig_Environment $environment)
    {
        $this->environment = $environment;
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return array(
            'mayday_user' => new \Twig_Function_Method($this, 'renderUser', array('is_safe' => array('html'))),
            'mayday_user_json' => new \Twig_Function_Method($this, 'renderUserJson', array('is_safe' => array('html'))),
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getGlobals()
    {
        return array(
            'react' => array(
                'host' => $this->reactHost,
                'port' => $this->reactPort,
            )
        );
    }

    /**
     * @param $uuid
     *
     * @return string
     */
    public function renderUser($uuid)
    {
        return $this->environment->loadTemplate('SensioLabsMaydayBundle::user.html.twig')->render(array(
            'user' => $this->userRepository->find($uuid)->asArray(),
        ));
    }

    /**
     * @param $uuid
     *
     * @return string
     */
    public function renderUserJson($uuid)
    {
        return json_encode($this->userRepository->find($uuid)->asArray());
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'sensiolabs_mayday';
    }
}
