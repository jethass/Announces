<?php

namespace Annonces\SiteBundle\Filter;

use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Form;

class FormFilterManager
{
    const SESSION_DATA_NAMESPACE_FORMAT = 'tms_filters/%s';

    protected $session;
    protected $request;

    /**
     * Constructor
     *
     * @param Session     $session
     * @param Request     $request
     */
    public function __construct(Session $session, Request $request)
    {
        $this->session = $session;
        $this->request = $request;
    }

    /**
     * Get session
     *
     * @return Session
     */
    protected function getSession()
    {
        return $this->session;
    }

    /**
     * Get request
     *
     * @return Request
     */
    protected function getRequest()
    {
        return $this->request;
    }

    /**
     * Submit
     *
     * @param Form    $form
     * @param boolean $keepFilters
     */
    public function submit(Form & $form, $keepFilters = false)
    {
        $rawData = $this->getRequest()->query->get($form->getName());

        if ($this->getRequest()->query->has('reset-filter')) {
            $this->removeFilterData($form->getName());
            $keepFilters = false;
            $rawData = null;
        }

        if ($keepFilters) {
            if (null !== $rawData) {
                $this->setFilterData(
                    $form->getName(),
                    $rawData
                );
            } else {
                $rawData = $this->getFilterData($form->getName());
            }
        }

        $form->submit($rawData);
    }

    /**
     * Set filter data
     *
     * @param string $name
     * @param array  $data
     */
    public function setFilterData($name, array $data)
    {
        $this->getSession()->set(
            sprintf(
                self::SESSION_DATA_NAMESPACE_FORMAT,
                $name
            ),
            $data
        );
    }

    /**
     * Get filter data
     *
     * @param  string $name
     * @return array
     */
    public function getFilterData($name)
    {
        return $this->getSession()->get(sprintf(
            self::SESSION_DATA_NAMESPACE_FORMAT,
            $name
        ));
    }

    /**
     * Has filter data
     *
     * @param  string $name
     * @return boolean
     */
    public function hasFilterData($name)
    {
        return
            $this->getSession()->has(sprintf(
                self::SESSION_DATA_NAMESPACE_FORMAT,
                $name
            )) ||
            $this->getRequest()->query->has($name)
        ;
    }

    /**
     * Remove filter data
     *
     * @param  string $name
     * @return mixed
     */
    public function removeFilterData($name)
    {
        return $this->getSession()->remove(sprintf(
            self::SESSION_DATA_NAMESPACE_FORMAT,
            $name
        ));
    }
}