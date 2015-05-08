<?php
/**
 * Created by PhpStorm.
 * User: xavier
 * Date: 5/8/15
 * Time: 12:38 PM
 */

namespace Latamautos\MicroserviceGateway\core;


interface IResource {

	public function store(array $args = array (), $body, array $queryString = array ());

	public function index(array $args = array (), array $queryString = array (), RestPagination $restPagination = null);

	public function update(array $args, $body, array $queryString = array ());

	public function delete(array $args, array $queryString = array ());

	public function show(array $args, array $queryString = array ());
} 