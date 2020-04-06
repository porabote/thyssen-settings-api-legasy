<?php
namespace App\View\Helper;

use Cake\View\Helper;
use Acl\Controller\ArosAcosController as Acl;

class OnHtmlHelper extends Helper
{

   // public $helpers = ['OnAcl'];
   //public $helpers = ['Url'];
    
    protected $entity = null;
    protected $twig = null;
    private $render;
    private $dropBlock;
    private $acl;
    private $jsPaths = [];

/*

    public function initialize(array $config)
    {
	   // parent::initialize();
	    $this->acl = new \Acl();//debug($this->acl);
	    $this->render = true;
    }
*/


    /**
     * Default config for this class
     *
     * @var array
     */
    protected $_defaultConfig = [
        'templates' => [
            'formStart' => '
                <form placeholder="{{placeholder}}" {{attrs|raw}}>',
            'formEnd' => '
                </form>',
            'input' => '
                  {%if label is defined %}<label class="form-item__label">{{label}}</label>{%endif%}               
                      <input placeholder="{{placeholder}}" {%if value is defined %}value="{{value}}"{%endif%}  {{attrs|raw}}>      	                     
            ',
            'textarea' => '
	            <div class="form-item no_padding">
                    <label class="form-item__label">{{label}}</label>	      
                    <div class="form-item__textarea-wrap">
	                    <textarea class="form-item__textarea" {{attrs|raw}}>{{text}}{%if value is defined %}{{value}}{%endif%}</textarea> 	                  
	                </div> 	       
	                <div class="form-item__info"></div>        
	            </div>               
            ',
            'select' => '
                <div class="form-item {%if wrap_class is not defined %}flex{%else%}{{wrap_class}}{%endif%} no_padding">
                  <label class="form-item__label">{{label}}</label>	      
                  <div class="form-item__select-wrap">	               
                      <select placeholder="{{placeholder}}" {{attrs|raw}}>{{options|raw}}</select>
                      {%if button_add %}
                          <a class="form-item__icon-plus tooltip sidebar-open" data-msg-type="complete" href="{{button_add.url|raw}}">{{button_add.title|raw}}</a> 
                      {%endif%}

                      {%if buttons %}
                          {% for key,button in buttons %}
                          <button type="button" class="{{button.class}}" id="{{button.id}}" {%if button.url is defined %}url=\'{{button.url}}\'{%endif%} {%if button.events is defined %}events=\'{{button.events}}\'{%endif%}>{{button_add.title|raw}}</button> 
                          {% endfor %} 
                      {%endif%}

	              </div> 	       
                  {{info}}
                        
	            </div>            
            ',
            'hidden' => '<input {{attrs|raw}}>',
            'file' => '<div class="form-item on-file__wrap">
                           
                           <label {{label_attrs|raw}}>
                               <span class="on-file__label__title">{{label.text}}</span>
                               <input {{input.multiple}} type="file" class="on-file__input" name="{{input.name}}" id="{{input.id}}">
                           </label>
                        </div>',
            // Поле быстрого поиска
            'inputFastFinder' => '
                <div class="content__top-filter fast-find__wrap">
                    <div class="fast-find__item">                  
                        <input placeholder="{{placeholder}}" {{attrs|raw}}> 

                        {%if buttons is defined%}
                            <div class="fast-find__item__buttons">
                                {% for key,button in buttons %}
                                    <button type="button" class="{{button.class}}">{{button_add.title|raw}}</button> 
                                {% endfor %} 
                            </div>
                        {%endif%}

                        {%if thumbler is defined and thumbler == true %}
                            <div class="fast-find__item__thumbler"></div>
                        {%endif%}
                    </div>         	                     
                </div>
            ',
            'on_input' => '
                <div class="form-item no_padding">
                  <label class="form-item__label">{{label}}</label>	      
                  <div class="form-item__input-wrap">	               

                      <input placeholder="{{placeholder}}" {%if value is defined %}value="{{value|escape}}"{%endif%} {{attrs|raw}}>
                      
                      {%if buttons %}
                          {% for key,button in buttons %}
                          <button type="button" class="{{button.class}}" events=\'{{button.events}}\'>{{button_add.title|raw}}</button> 
                          {% endfor %} 
                      {%endif%}
	              </div> 	       
                  {{info}}       
	            </div>            
            ',
            'link' => '
                <a {{attrs|raw}}>{{text|raw}} </a>          
            ',
            'image' => '
                <img src="{{url}}" {{attrs|raw}}>          
            ',
            'inputFinder' => '
                <div class="form-item flex no_padding">
                    <label class="form-item__label">{{label}}</label>	      
                    <div class="form-item__input-finder-wrap">	               
                        <input class="form-item__input-finder listener" placeholder="{{placeholder}}" {{attrs|raw}}>
                        {%if itemsArea == true %}<div class="on-input__finder__items"></div>{%endif%}
                    </div> 	       
                    {{info}}       
                </div>            
            ',
            'checkbox' => '
                <div class="form-item__checkbox-wrap {%if class_wrap is defined %}{{class_wrap}}{%endif%}">
                  <input name="{{name}}" value="0" type="hidden" checked="checked"/>
                  <input name="{{name}}" {%if checked is defined and checked == "checked" %}checked="{{checked}}"{%endif%}  {%if params is defined %}data-params=\'{{params}}\'{%endif%} {%if value is defined %}value="{{value}}"{%else%}value="1" {%endif%} type="checkbox" class="{%if class is not defined %}form-item__checkbox{%else%}{{class}}{%endif%}" {%if disabled is defined and disabled %}disabled="disabled"{%endif%} id="{{id}}" />
                  <label for="{{id}}">{{label}}</label> 
                </div> 
            ',
            'button' => '<button {{attrs|raw}}>{{text}}</button>',
            'datetime' => '
                {% for key,field in fields %}
                    
                    {% if field.type == "date" %}
                        
                        <div class="form-item flex">
                            <label class="form-item__label">{{field.title}}</label>
                            <div class="form-item__date-wrap">
                                <input type="text" name="{{field.name}}" {%if field.disabled is defined %}disabled="disabled"{%endif%}
                                class="{%if field.class is not defined %}form-item__date date_mask{%else%}{{field.class}}{%endif%}" id="{{field.id}}" 
                                value="{{field.value}}">            
                                <span data-datepicker=\'{ "input_id" : "#{{field.id}}" }\' class="form-item__icon-date" data-msg-type="complete"></span>
                            </div>
                        </div>

                    {% endif %}
                  
                {% endfor %}                        
            '
        ]
    ];


    function __construct()
    {
 	    
    }

    function display($element_alias, $options = [])
    {
	    $this->render = false;
	   
	    return $this->$element_alias($options);
    }

    function script($element_alias, $options = [])
    {
	    $this->render = false;
	   
	    return $this->$element_alias($options);
    }
    
    function assignScripts($paths)
    {
	    foreach($paths as $js) {

            $defaultOptions = [
	            'type' => 'text/javascript',
	            'defer' => false
            ];        
            $options = array_merge($defaultOptions, $js);

	        $this->jsPaths[] = $options;
	    }
	    
    }
    
    function displayScripts($options){

        if(JS_CACHE) {

            $defaultOptions = [
	            'prefix' => 'cache',
	            'type' => 'text/javascript',
	            'defer' => false
            ];        
            $options = array_merge($defaultOptions, $options);
		    
            $cache = '';
	        if(!is_dir(JS_CACHE_PATH . $options['prefix'])) {
		        
		        $this->__checkDirectory(JS_CACHE_PATH . $options['prefix']);
		        
		        $outPath = JS_CACHE_PATH . $options['prefix'] . '/' . date('d_m_Y_His') . '.js';
		        
		        foreach($this->jsPaths as $path) {
		    	    $cache .= file_get_contents(WWW_ROOT . $path['src']);				    		    
		        }
		        
		        file_put_contents($outPath, $cache);
	        } else {
		        $outPath = '/' . JS_CACHE_PATH . $options['prefix'] . '/' . scandir(JS_CACHE_PATH . $options['prefix'])[2];
	        }
	        return '<script src="' . str_replace(WWW_ROOT, '', $outPath) . '" type="' .$options['type']. '" ></script>';
	    } else {
		    
		    $out = '';
		    foreach($this->jsPaths as $path) {
		        $out .= '<script src="' . $path['src'] . '" type="' .$path['type']. '" ></script>';
		    }
		    return $out;
	    }
	    

    }

    function formStart($options)
    {
	    if(!isset($options['action'])) $options['action'] = $_SERVER['REQUEST_URI'];

	    $data = $options;	    
	   
	    $data['attrs'] = '';
	    if(isset($options['data'])) {
		    $this->entity = $options['data'];
		    unset($options['data']);
	    }
	    
	    foreach($options as $key => $value){
		    if(is_string($value)) $data['attrs'] .= $key.'=\''.$value.'\' ';
	    }

	    return $this->__output($data, 'formStart');
    }

    function formEnd()
    {
	    return $this->__output([], 'formEnd');
	    $this->entity = null;
    }


    function select($options)
    {
	    $data = $options;
	    $data['attrs'] = '';

        if(!isset($options['selected']) && isset($this->entity[$options['name']])) $options['selected'] = $this->entity[$options['name']];
	  
	    foreach($options as $key => $value){
		    if(is_string($value)) $data['attrs'] .= $key.'=\''.$value.'\' ';
	    }
	    
	    $data['options'] = '';
	    if(isset($options['empty']) && $options['empty']) $data['options'] .= '<option value="">'.$options['empty'].'</option>';	    
	    $selected_value = (isset($options['selected']) && $options['selected']) ? $options['selected'] : null;

	    $options_list = [];
	    if(isset($options['options'])) foreach($options['options'] as $value => $title){
		    $options_list[$value] = $value;
		    $data['options'] .= '<option value="'.$value.'" '.(($selected_value == $value) ? 'selected="selected"' : '').'>'.$title.'</option>';
		}

		if($selected_value && !isset($options_list[$selected_value])) { 
			$data['options'] .= '<option value="'.$selected_value.'" selected="selected">'.$selected_value.'</option>';
		}	

	    return $this->__output($data, 'select');
    }

    function inputFinder($options)
    {
	    $optionsDefault = [
		    'itemsArea' => true
	    ];
	    $options = array_merge($optionsDefault, $options);
	    
	    $data = $options;
	    $data['attrs'] = '';
	    
	    foreach($options as $key => $value){
		    if(is_string($value)) $data['attrs'] .= $key.'=\''.$value.'\' ';
	    }

	    return $this->__output($data, 'inputFinder');
    }

    public function buildDropList( $config, $record ) 
    {
	    $this->acl = new Acl();

        $this->dropBlock = '<div class="drop-button">  		
  	                    <a href="#" class="drop-button__title"></a>  
  	                    <div class="drop-button hide-blok">';


        if(isset($config['drop_panel'])) {

            foreach($config['drop_panel'] as $link ) { //debug($record);

	    
	            $link['text'] = $link['title'];

	            $link['check'] = (isset($link['check'])) ? $link['check'] : 1;
	            $link['record'] = (is_object($record)) ? $record->toArray() : $record;
	          
	            $link['href'] = $this->__output($link, 'customHref', $link['href'], false);
	            


	          
	            $this->dropBlock .= $this->display('link', $link);
	                  
            }

        } else if (isset($config['submenu'])) {
 	        
            foreach($config['submenu'] as $title => $link ) { 
	            
	            $href = $link['link'];
	            foreach($link['param'] as $param) {
		            $href .= $record[$param].'/';    
	            }
	            $attr_list = [];
	            if(isset($link['attr'])) {
	                foreach($link['attr'] as $attr => $value) {
	                    $attr_list[$attr] = $value;    
	                }
	            }
	    
	            $attr_list['text'] = $title;
	            $attr_list['href'] = $href;
	            $attr_list['check'] = 1;
	            
	            $this->dropBlock .= $this->display('link', $attr_list);
	                  
            }
  	        

        }
       
        
        $this->dropBlock .= '</div>           
                     </div>';        
        return $this->dropBlock; 	    
    }


    function link($options)
    {
	    $data = $options;
	    $data['attrs'] = '';

	    if(isset($options['check']) && $options['check']) {
		    if(!$this->acl->checkLink($options)) return null;
		}    
	   
	    foreach($options as $key => $value){
		    if(is_string($value)) $data['attrs'] .= $key.'=\''.$value.'\' ';
	    }
	    
	    return $this->__output($data, 'link');
    }

    function image($options)
    {
	    $data = $options;
	    $data['attrs'] = '';

/*
	    if(isset($options['check']) && $options['check']) {
		    if(!$this->acl->checkLink($options)) return null;
		} 
*/   
	   
	    foreach($options as $key => $value){
		    if(is_string($value)) $data['attrs'] .= $key.'=\''.$value.'\' ';
	    }

	    return $this->__output($data, 'image');
    }

    function input($options)
    {
	    $data = $options;

	    $escape = (isset($options['escape']) && !$options['escape']) ? false : true;

        if(!isset($options['value']) && isset($this->entity[$options['name']])) $options['value'] = (string)$this->entity[$options['name']];
        if(isset($options['value'])) {
	        $options['value'] = ($escape) ? htmlspecialchars($options['value']) : $options['value'];
	        $data['value'] = $options['value'];
	        unset($options['value']);
	    }
       //debug($options['value']);
        if (isset($data['class']) && strpos($data['class'], 'form-item__text') !== false) {
            $pattern_alias = 'on_input';
        } else {
	        $pattern_alias = 'input';
        }

	    $data['attrs'] = '';
	    
	    foreach($options as $key => $value){
		    if(is_string($value)) $data['attrs'] .= $key.'=\''.$value.'\' ';
	    }

	    return $this->__output($data, $pattern_alias);
    }

    function inputFastFinder($options)
    {
	    $data = $options;

	    $data['attrs'] = '';
	    
	    foreach($options as $key => $value){
		    if(is_string($value)) $data['attrs'] .= $key.'=\''.$value.'\' ';
	    }

	    return $this->__output($data, 'inputFastFinder');
    }


    function textarea($options)
    {
	    $data = $options;	    
	   
	    $data['attrs'] = '';
	    
	    foreach($options as $key => $value){
		    if(is_string($value)) $data['attrs'] .= $key.'=\''.$value.'\' ';
	    }

        if(!isset($data['value']) && isset($this->entity[$data['name']])) $data['value'] = (string) $this->entity[$data['name']];

	    return $this->__output($data, 'textarea');
    }

    function checkbox($options)
    {
	    return $this->__output($options, 'checkbox');
    }
    
    function hidden($options)
    {
	    $data = $options;
	    $data['attrs'] = '';
	    
	    foreach($options as $key => $value){
		    if(is_string($value)) $data['attrs'] .= $key.'=\''.$value.'\' ';
	    }

	    return $this->__output($data, 'hidden');
    }

    function file($options)
    {
	    $data = $options;

	    $data['label_attrs'] = '';
	    $data['input_attrs'] = '';
	    
	    foreach($options['label'] as $key => $value){
		    if(is_string($value)) $data['label_attrs'] .= $key.'=\''.$value.'\' ';
	    }

	    foreach($options['input'] as $key => $value){
		    if(is_string($value)) $data['input_attrs'] .= $key.'=\''.$value.'\' ';
	    }

	    return $this->__output($data, 'file');
    }

    
    /*
	 * Set Html Button   
     */
    function button($options)
    {
	    $data = $options;
	    $data['attrs'] = '';
	    
	    foreach($options as $key => $value){
		    if(is_string($value)) $data['attrs'] .= $key.'=\''.$value.'\' ';
	    }

	    return $this->__output($data, 'button');
    }

    /*
	 * Set Html Date and Time   
     */
    function datetime($options)
    {
	    $data = $options;

	    return $this->__output($data, 'datetime');
    }

    /*
	 * Fill template
	 *
	 * array $data - data variables
	 * string $teplate_alias - for finding in default patterns
	 * string $template - custom pattern 
	 *  
     */
    function __output($data, $teplate_alias, $template = null, $asset = false)
    {
        if(!$template) {
            $loader = new \Twig_Loader_Array( [
                '_defaultConfig.templates.'.$teplate_alias => $this->_defaultConfig['templates'][$teplate_alias],
            ]);
        } else {
            $loader = new \Twig_Loader_Array( [
                '_defaultConfig.templates.'.$teplate_alias => $template,
            ]);	        
        }
        
        $this->twig = new \Twig_Environment($loader, ['cache' => false]);

		$link = $this->twig->render('_defaultConfig.templates.'.$teplate_alias, $data);
		if($asset) $this->dropBlock .= $link;
		  
		else return $link;   
    }

    # Проверяем папку на существование, если нет, рекурсивно создаем
	public function __checkDirectory($dir = null)
	{
		$uploadDir = trim($dir);
		$finalDir = $dir;

		if (!file_exists($finalDir)) { mkdir($finalDir, 0755, true); }
		elseif (!is_writable($finalDir)) { chmod($finalDir, 0755); }
	}

}

