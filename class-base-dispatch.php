<?php

namespace wskl_host_lib;


abstract class Base_Dispatch {

	/**
	 * @var string
	 */
	private $app_name;

	/** @var  \wskl_host_lib\Bootstrap */
	private $bootstrap;

	public function __construct( Bootstrap $bootstrap, $app_name ) {
		$this->set_bootstrap( $bootstrap );
		$this->app_name = $app_name;
	}

	abstract public function init_dispatch();

	/**
	 * @param $bootstrap \wskl_host_lib\Bootstrap
	 */
	public function set_bootstrap( Bootstrap $bootstrap ) {

		$this->bootstrap = $bootstrap;
	}

	/**
	 * @return \wskl_host_lib\Bootstrap
	 */
	public function get_bootstrap() {

		return $this->bootstrap;
	}

	/**
	 * @param $control_slug string
	 * @param $app_name     string
	 *
	 * @return mixed
	 */
	public function control( $control_slug, $app_name = '' ) {

		if( !$app_name ) {
			$app_name = $this->app_name;
		}

		$fqn      = $this->compose_control_fqn( $app_name, $control_slug );
		$instance = new $fqn( $this->get_bootstrap(), $app_name, $control_slug );

		return $instance;
	}

	/**
	 * @param $app_name string
	 * @param $slug string
	 *
	 * @return string
	 */
	protected function compose_control_fqn( $app_name, $slug ) {

		$bootstrap = $this->get_bootstrap();
		$app_namespace = $bootstrap->get_app_namespace();

		return compose_fqn( $app_namespace, $app_name, 'control', $slug );
	}
}
