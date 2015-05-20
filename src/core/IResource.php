<?php
/**
 * Created by PhpStorm.
 * User: xavier
 * Date: 5/8/15
 * Time: 12:38 PM
 */

namespace Latamautos\MicroserviceGateway\core;


interface IResource {

	public function setPathParams($pathParamsArray = array ());

	public function setQueryParams($queryParamsArray = array ());

	public function store($body, array $queryString = array ());

	public function index(array $queryString = array ());

	public function update($id, $body, array $queryString = array ());

	public function delete($id, array $queryString = array ());

	public function show($id, array $queryString = array ());
} 