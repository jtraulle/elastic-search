<?php

namespace Cake\ElasticSearch;

use Cake\Datasource\QueryTrait;
use Cake\ElasticSearch\ResultSet;
use Cake\ElasticSearch\Type;
use Elastica\Query as ElasticaQuery;
use IteratorAggregate;

class Query implements IteratorAggregate {

	use QueryTrait;

	public function __construct(Type $repository) {
		$this->repository($repository);
	}

	public function applyOptions(array $options) {
		$this->_options = $options + $this->_options;
	}

	protected function _execute() {
		$connection = $this->_repository->connection();
		$name = $this->_repository->name();
		$type = $connection->getIndex()->getType($name);

		$query = $this->_compileQuery();
		return new ResultSet($type->search($query));
	}

	protected function _compileQuery() {
		return new ElasticaQuery;
	}

}
