<?php namespace Keyhunter\Administrator\Form\Type;

use Form;
use Keyhunter\Administrator\Form\Element;

class Text extends Element
{
	/**
	 * The specific defaults for subclasses to override
	 *
	 * @var array
	 */
	protected $attributes = [
		'maxlength' 	=> 255,
		'class'			=> 'form-control input-sm',
		'style'			=> 'width: 300px;'
	];

	/**
	 * The specific rules for subclasses to override
	 *
	 * @var array
	 */
	protected $rules = array(
		'maxlength' 	=> 'integer|min:0|max:255'
	);

	public function renderInput()
	{
		return Form::text($this->name, $this->value, $this->attributes);
	}
}