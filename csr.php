<?php
/* ============================================================ *//**
 * c-shamoo router
 * 
 * URI routing framework like c-shamoo
 * version 1.0
 * 
 * @package csr
 * @author Takahiro Suzuki <szktkhr@szktkhr.org>
 */
/* ============================================================ *//*
 Define options
*//* ============================================================ */
/**
 * Define CSR mode (true | false)
 * <p>if true then CSR running develop mode.</p>
 */
CSR::define('CSR_DEVELOP_MODE', true);
/* ============================================================ *//*
 Define directories
*//* ============================================================ */
/**
 * Define CSR install directory
 */
CSR::define('INSTALL_DIR', dirname($_SERVER['SCRIPT_FILENAME']) . '/');
/**
 * Define CSR applciations directory
 */
CSR::define('APP_DIR', INSTALL_DIR . 'applications' . '/');
/**
 * Define CSR applciations controller directory
 */
CSR::define('APP_CONTROLLER_DIR', APP_DIR);
/**
 * Define CSR controllers directory
 */
CSR::define('CONTROLLERS_DIR', APP_DIR . 'controllers/');
/**
 * Define CSR views directory
 */
CSR::define('VIEWS_DIR', APP_DIR . 'views/');
/**
 * Define CSR models directory
 */
CSR::define('MODELS_DIR', APP_DIR . 'models/');
/**
 * Define CSR caches directory
 */
CSR::define('CACHES_DIR', APP_DIR . 'caches/');
/**
 * Define CSR modules directory
 */
CSR::define('MODULES_DIR', INSTALL_DIR . 'modules/');
/**
 * Define CSR error documents directory
 */
CSR::define('ERRORS_DIR', APP_DIR . 'errors/');
/**
 * Define application controller name
 */
CSR::define('APP_CONTROLLER_FILE_NAME', '_app_controller.php');
/**
 * Define layout file name
 */
CSR::define('LAYOUT_FILE_NAME', '_layout.php');
/* ============================================================ *//*
 Define pathes
*//* ============================================================ */
/**
 * Define CSR root directory from document root
 */
CSR::define('ROOT_PATH', dirname($_SERVER['SCRIPT_NAME']) . '/');
/* ============================================================ *//*
 Define events
*//* ============================================================ */
/**
 * Define application start event
 */
CSR::define('EVENT_APPLICATION_START', 'event_application_start');
/**
 * Define application end event
 */
CSR::define('EVENT_APPLICATION_END', 'event_application_end');
/**
 * Define before parse route event
 */
CSR::define('EVENT_BEFORE_PARSE_ROUTE', 'event_before_parse_route');
/**
 * Define after parse route event
 */
CSR::define('EVENT_AFTER_PARSE_ROUTE', 'event_after_parse_route');
/**
 * Define before action event
 */
CSR::define('EVENT_BEFORE_ACTION', 'event_before_action');
/**
 * Define after action event
 */
CSR::define('EVENT_AFTER_ACTION', 'event_after_action');
/**
 * Define before render event
 */
CSR::define('EVENT_BEFORE_RENDER', 'event_before_render');
/**
 * Define after render event
 */
CSR::define('EVENT_AFTER_RENDER', 'event_after_render');
/**
 * Define before output event
 */
CSR::define('EVENT_BEFORE_OUTPUT', 'event_before_output');
/**
 * Define after output event
 */
CSR::define('EVENT_AFTER_OUTPUT', 'event_after_output');
/**
 * Define dispatch error event
 */
CSR::define('EVENT_DISPATCH_ERROR', 'event_dispatch_error');
/**
 * Define phase run event
 */
CSR::define('EVENT_PHASE_RUN', 'event_phase_run');
/* ============================================================ *//*
 Define phases
*//* ============================================================ */
/**
 * Define application start phase
 */
CSR::define('PHASE_APPLICATION_START', 'phase_application_start');
/**
 * Define application end phase
 */
CSR::define('PHASE_APPLICATION_END', 'phase_application_end');
/**
 * Define parse route phase
 */
CSR::define('PHASE_PARSE_ROUTE', 'phase_parse_route');
/**
 * Define action phase
 */
CSR::define('PHASE_ACTION', 'phase_action');
/**
 * Define render phase
 */
CSR::define('PHASE_RENDER', 'phase_render');
/**
 * Define output phase
 */
CSR::define('PHASE_OUTPUT', 'phase_output');
/* ============================================================ *//**
 * c-shamoo router base object class
 * 
 * Object class for PHP4
 * 
 * @package csr
 *//* ============================================================ */
class CSR_Object {
	/**
	 * Constructor for PHP4
	 */
	function CSR_Object() {
		$args = func_get_args();
		call_user_func_array(array(&$this, '__construct'), $args);
	}
	/**
	 * Constructor for PHP5
	 */
	function __construct() {}
}
/* ============================================================ *//**
 * c-shamoo router event object class
 * 
 * @package csr
 *//* ============================================================ */
class CSR_EventObject extends CSR_Object {
	/**
	 * Event collection
	 * @var array
	 * @access private
	 */
	var $_events = array();
	/**
	 * Constructor
	 */
	function __construct() {
		parent::__construct();
	}
	/**
	 * Event add method
	 * 
	 * Usage
	 * <code>
	 * function handler1() {
	 * 	echo "run!";
	 * }
	 * function handler2() {
	 * 	echo "walk";
	 * }
	 * $event = &new CSR_EventObject();
	 * $event->addEvent('event_name', 'handler1');
	 * $event->triggerEvent('event_name');// run!
	 * $event->addEvent('event_name', 'handler2');
	 * $event->triggerEvent('event_name');// run!walk
	 * </code>
	 * 
	 * @param string event name
	 * @param mixed event handler
	 * @return void
	*/
	function addEvent($event, $handler) {
		if (!isset($this->_events[$event])) $this->_events[$event] = array();
		$this->_events[$event][] = $handler;
	}
	/**
	 * Event remove method
	 * 
	 * Usage
	 * <code>
	 * function handler1() {
	 * 	echo "run!";
	 * }
	 * $event = &new CSR_EventObject();
	 * $event->addEvent('event_name', 'handler1');
	 * $event->triggerEvent('event_name');// run!
	 * $event->removeEvent('event_name', 'handler1');
	 * $event->triggerEvent('event_name');// (nothing to output)
	 * </code>
	 * 
	 * @param string event name
	 * @param mixed event handler
	 * @return void
	 */
	function removeEvent($event, $handler) {
		if (isset($this->_events[$event])) {
			foreach ($this->_events[$event] as $index => $e) {
				if ($handler == $e) unset($this->_events[$event][$index]);
			}
		}
	}
	/**
	 * Event force remove method
	 * 
	 * A method to delete all the target events.
	 * 
	 * Usage
	 * <code>
	 * function handler1() {
	 * 	echo "run!";
	 * }
	 * $event = &new CSR_EventObject();
	 * $event->addEvent('event_name', 'handler1');
	 * $event->addEvent('event_name', 'handler1');
	 * $event->addEvent('event_name', 'handler1');
	 * $event->triggerEvent('event_name');// run!run!run!
	 * $event->forceRemove('event_name');
	 * $event->triggerEvent('event_name');// (nothing to output)
	 * </code>
	 * 
	 * @param string event name
	 * @return void
	 */
	function forceRemove($event) {
		unset($this->_events[$event]);
	}
	/**
	 * Execute event
	 * 
	 * Usage
	 * <code>
	 * function handler1() {
	 * 	echo "run!";
	 * }
	 * $event = &new CSR_EventObject();
	 * $event->addEvent('event_name', 'handler1');
	 * $event->triggerEvent('event_name');// run!
	 * </code>
	 * 
	 * @param string event name
	 * @param array parameters
	 * @return array event result
	 */
	function triggerEvent($event, $params = array()) {
		if (isset($this->_events[$event])) {
			$args = func_get_args();
			$results = array();
			foreach ($this->_events[$event] as $handler) {
				if (in_array($handler, $this->_events[$event])) {
					// if (call_user_func_array($handler, array($event, $params)) === false) $result = false;
					// $results[$event] = call_user_func_array($handler, array($event, $params));
					$results[] = call_user_func_array($handler, array($event, $params));
				}
			}
			return $results;
		}
	}
}
/* ============================================================ *//**
 * c-shamoo router phase object class
 * 
 * @package csr
 *//* ============================================================ */
class CSR_PhaseObject extends CSR_Object {
	/**
	 * Current phase index
	 * @var int
	 * @access private
	 */
	var $_current = 0;
	/**
	 * Phase collection
	 * @var array
	 * @access private
	 */
	var $_phases = array();
	/**
	 * Is phase running?
	 * @var boolean
	 * @access private
	 */
	var $_running = false;
	
	function __construct() {
		parent::__construct();
	}
	/**
	 * Add phase method
	 * 
	 * When the $nextOf which there is not was appointed, dont add it.
	 * Overwrite when $phase was exists.
	 * 
	 * Usage
	 * <code>
	 * function phase1() {
	 * 	echo "phase1:";
	 * }
	 * function phase2() {
	 * 	echo "phase2:";
	 * }
	 * function phase3() {
	 * 	echo "phase3:";
	 * }
	 * $phase = new CSR_PhaseObject();
	 * $phase->push('sample_phase_1', 'phase1');
	 * $phase->push('sample_phase_2', 'phase2');
	 * $phase->push('sample_phase_3', 'phase3');
	 * $phase->run();
	 * // phase1:phase2:phase3
	 * </code>
	 * 
	 * @access public
	 * @param string phase name
	 * @param mixed function name
	 * @param string [optional] 
	 * @return void
	 */
	function push($phase, $handler, $nextOf = null) {
		if (!is_null($nextOf)) {
			if ($this->isExists($nextOf) === false) {
				// 対象 $nextOf が存在しないため、エラー
				trigger_error(sprintf('Target phase <em>%s</em> does not exists.', $nextOf), E_USER_WARNING);
				return;
			}
			// 登録しようとしているフェイズが既にあったら順序を変更するために一度削除
			if ($this->isExists($phase)) $this->delete($phase);
			$newPhases = array();
			// んで登録
			foreach ($this->_phases as $phaseArray) {
				$newPhases[] = $phaseArray;
				if ($nextOf === $phaseArray['phase']) $newPhases[] = array('phase' => $phase, 'handler' => $handler);
			}
			$this->_phases = $newPhases;
		} else {
			// 上書きの場合は、前合った場所に上書きする
			if (($index = $this->isExists($phase)) || $index !== false) {
				$this->_phases[$index] = array('phase' => $phase, 'handler' => $handler);
			} else {
				// 新規登録
				$this->_phases[] = array('phase' => $phase, 'handler' => $handler);
			}
		}
	}
	/**
	 * Delete phase method
	 * 
	 * delete target phase
	 * 
	 * Usage
	 * <code>	
	 * function phase1() {
	 * 	echo "phase1:";
	 * }
	 * function phase2() {
	 * 	echo "phase2:";
	 * }
	 * function phase3() {
	 * 	echo "phase3:";
	 * }
	 * $phase = new CSR_PhaseObject();
	 * $phase->push('sample_phase_1', 'phase1');
	 * $phase->push('sample_phase_2', 'phase2');
	 * $phase->push('sample_phase_3', 'phase3');
	 * $phase->delete('sample_phase_2');
	 * $phase->run();
	 * // phase1:phase3
	 * </code>
	 * 
	 * @access public
	 * @param string phase name
	 * @return void
	 */
	function delete($phase) {
		$currentPhase = $this->_phases[$this->_current];
		$newPhases = array();
		foreach ($this->_phases as $phaseArray) {
			if ($phaseArray['phase'] === $phase) continue;
			$newPhases[] = $phaseArray;
		}
		$this->_phases = $newPhases;
		// Fix $current
		foreach ($this->_phases as $index => $phaseArray) {
			if ($currentPhase['phase'] === $phaseArray['phase']) {
				$this->_current = $index;
				break;
			}
		}
	}
	/**
	 * List up registered phase method
	 * 
	 * 登録されているフェイズの一覧を返す
	 * 
	 * Usage
	 * <code>
	 * function phase1() {
	 * 	echo "phase1:";
	 * }
	 * function phase2() {
	 * 	echo "phase2:";
	 * }
	 * function phase3() {
	 * 	echo "phase3:";
	 * }
	 * $phase = new CSR_PhaseObject();
	 * $phase->push('sample_phase_1', 'phase1');
	 * $phase->push('sample_phase_2', 'phase2');
	 * $phase->push('sample_phase_3', 'phase3');
	 * print_r($phase->listup());
	 * // Array
	 * // (
	 * //     [sample_phase_1] => phase1
	 * //     [sample_phase_2] => phase2
	 * //     [sample_phase_3] => phase3
	 * // )
	 * </code>
	 * 
	 * @access public
	 * @return array phase list
	 */
	function listup() {
		$listArray = array();
		foreach ($this->_phases as $phase) {
			$listArray[$phase['phase']] = $phase['handler'];
		}
		return $listArray;
	}
	/**
	 * Progress phase method
	 * 
	 * フェイズを一つ進める
	 * 
	 * Usage
	 * <code>
	 * function phase1() {
	 * 	global $phase;
	 * 	$phase->next();
	 * 	echo "phase1:";
	 * }
	 * function phase2() {
	 * 	echo "phase2:";
	 * }
	 * function phase3() {
	 * 	echo "phase3:";
	 * }
	 * $phase = new CSR_PhaseObject();
	 * $phase->push('sample_phase_1', 'phase1');
	 * $phase->push('sample_phase_2', 'phase2');
	 * $phase->push('sample_phase_3', 'phase3');
	 * $phase->run();
	 * // phase1:phase3:
	 * </code>
	 * 
	 * @access public
	 * @return void
	 */
	function next() {
		$this->_current++;
	}
	/**
	 * Retrogress phase method
	 * 
	 * フェイズを一つ戻す
	 * 
	 * Usage
	 * <code>
	 * function phase1() {
	 * 	global $phase;
	 * 	echo "phase1:";
	 * }
	 * function phase2() {
	 * 	global $phase, $phaseCounter;
	 * 	if ($phaseCounter++ < 5) $phase->prev();
	 * 	echo "phase2:";
	 * }
	 * function phase3() {
	 * 	echo "phase3:";
	 * }
	 * $phaseCounter = 0;
	 * $phase = new CSR_PhaseObject();
	 * $phase->push('sample_phase_1', 'phase1');
	 * $phase->push('sample_phase_2', 'phase2');
	 * $phase->push('sample_phase_3', 'phase3');
	 * $phase->run();
	 * // phase1:phase2:phase2:phase2:phase2:phase2:phase2:phase3:
	 * </code>
	 * 
	 * @access public
	 * @return void
	 */
	function prev() {
		$this->_current--;
	}
	/**
	 * Execute phase method
	 * 
	 * フェイズを順次開始する
	 * 完走した場合 true 、完走出来なかった場合、 false を返す。
	 * 
	 * Usage
	 * <code>
	 * function phase1() {
	 * 	echo "phase1:";
	 * }
	 * function phase2() {
	 * 	echo "phase2:";
	 * }
	 * function phase3() {
	 * 	echo "phase3:";
	 * }
	 * $phase = new CSR_PhaseObject();
	 * $phase->push('sample_phase_1', 'phase1');
	 * $phase->push('sample_phase_2', 'phase2');
	 * $phase->push('sample_phase_3', 'phase3');
	 * $phase->run();
	 * // phase1:phase2:phase3
	 * </code>
	 * 
	 * @access public
	 * @return bool phase done status
	 */
	function run() {
		$this->_running = true;
		while ($this->hasNext()) {
			// 要検証 ↓
			if (!$this->_running) {/* $this->next(); */ break;}
			$phase = $this->_phases[$this->_current]['phase'];
			$handler = $this->_phases[$this->_current]['handler'];
			CSR::triggerEvent(EVENT_PHASE_RUN, $phase);
			call_user_func_array($handler, array($phase));
			$this->next();
		}
		// 乾燥したら isrunning = falseに
		if (!$this->hasNext()) {
			$this->_running = false;
			return true;
		} else return false;
	}
	/**
	 * Pause phase method
	 * 
	 * フェイズをの実行を停止する
	 * もうちょいテストが必要
	 * 
	 * Usage
	 * <code>
	 * function phase1() {
	 * 	global $phase;
	 * 	$phase->pause();
	 * 	echo "phase1:";
	 * }
	 * function phase2() {
	 * 	echo "phase2:";
	 * }
	 * function phase3() {
	 * 	echo "phase3:";
	 * }
	 * $phase = new CSR_PhaseObject();
	 * $phase->push('sample_phase_1', 'phase1');
	 * $phase->push('sample_phase_2', 'phase2');
	 * $phase->push('sample_phase_3', 'phase3');
	 * $phase->run();
	 * echo "=====";
	 * $phase->run();
	 * // phase1:=====phase2:phase3:
	 * </code>
	 * 
	 * @access public
	 * @return void
	 */
	function pause() {
		$this->_running = false;
	}
	/**
	 * Move to target phase
	 * 
	 * 次に実行するフェイズを指定する。
	 * 指定されたフェイズが存在しない場合、 false を返し、
	 * 正常にフェイズ移動ができた場合、 true を返す。
	 * 
	 * Usage
	 * <code>
	 * function phase1() {
	 * 	global $phase, $phaseCounter;
	 * 	echo "1";
	 * 	if ($phaseCounter < 2) $phase->moveTo('sample_phase_3');
	 * }
	 * function phase2() {
	 * 	global $phase;
	 * 	echo "2";
	 * }
	 * function phase3() {
	 * 	global $phase, $phaseCounter;
	 * 	echo "3";
	 * 	if ($phaseCounter++ < 4) $phase->moveTo('sample_phase_1');
	 * }
	 * $phaseCounter = 0;
	 * $phase = new CSR_PhaseObject();
	 * $phase->push('sample_phase_1', 'phase1');
	 * $phase->push('sample_phase_2', 'phase2');
	 * $phase->push('sample_phase_3', 'phase3');
	 * $phase->run();// 1313123123123
	 * </code>
	 * 
	 * @access public
	 * @param string phase name
	 * @param array [optional] params
	 * @return bool move status
	 */
	function moveTo($phase, $params = array()) {
		$index = $this->isExists($phase);
		if ($index === false) return false;
		$this->_current = $index - 1;
		return true;
	}
	/**
	 * Check phase status method
	 * 
	 * 現在フェイズが進行しているかどうかのテストをする
	 * 
	 * Usage
	 * <code>
	 * function phase1() {
	 * 	global $phase;
	 * 	var_dump($phase->isRunning());
	 * }
	 * function phase2() {
	 * 	global $phase;
	 * 	var_dump($phase->isRunning());
	 * }
	 * function phase3() {
	 * 	global $phase;
	 * 	var_dump($phase->isRunning());
	 * }
	 * $phase = new CSR_PhaseObject();
	 * $phase->push('sample_phase_1', 'phase1');
	 * $phase->push('sample_phase_2', 'phase2');
	 * $phase->push('sample_phase_3', 'phase3');
	 * var_dump($phase->isRunning());
	 * $phase->run();
	 * var_dump($phase->isRunning());
	 * // bool(false) bool(true) bool(true) bool(true) bool(false)
	 * </code>
	 * 
	 * @access public
	 * @return bool Is phase running?
	 */
	function isRunning() {
		return $this->_running;
	}
	/**
	 * Check phase register status method
	 * 
	 * 与えられた名前のフェイズが登録されているかどうかを確認する。
	 * 登録されていれば、 index を返し、
	 * 登録されていなければ false を返す。
	 * 
	 * if ($phase->isExists('some_phase'))
	 * として評価すると、指定したフェイズが最初だった場合、0が返り、実行しないので、注意(=== falseと比較)。
	 * 
	 * Usage
	 * <code>
	 * function phase1() {
	 * 	echo "phase1:";
	 * }
	 * function phase2() {
	 * 	echo "phase2:";
	 * }
	 * function phase3() {
	 * 	echo "phase3:";
	 * }
	 * $phase = new CSR_PhaseObject();
	 * $phase->push('sample_phase_1', 'phase1');
	 * $phase->push('sample_phase_2', 'phase2');
	 * $phase->push('sample_phase_3', 'phase3');
	 * var_dump($phase->isExists('sample_phase_1'));// int(0)
	 * var_dump($phase->isExists('sample_phase_2'));// int(1)
	 * var_dump($phase->isExists('sample_phase_3'));// int(2)
	 * var_dump($phase->isExists('sample_phase_4'));// bool(false)
	 * </code>
	 * 
	 * @access public
	 * @param string phase name
	 * @return mixed phase index or false
	 */
	function isExists($phase) {
		foreach ($this->_phases as $index => $phaseArray) {
			if ($phaseArray['phase'] === $phase) return $index;
		}
		return false;
	}
	/**
	 * フェイズ進行可能状況テストメソッド
	 * 
	 * フェイズが次のフェイズを持っているかどうかを確認する。
	 * 次のフェイズを持っていれば true
	 * 持っていなければ false を返す。
	 * 
	 * Usage
	 * <code>
	 * function phase1() {
	 * 	echo "phase1:";
	 * }
	 * function phase2() {
	 * 	echo "phase2:";
	 * }
	 * function phase3() {
	 * 	echo "phase3:";
	 * }
	 * $phase = new CSR_PhaseObject();
	 * $phase->push('sample_phase_1', 'phase1');
	 * $phase->push('sample_phase_2', 'phase2');
	 * $phase->push('sample_phase_3', 'phase3');
	 * while ($phase->hasNext()) {
	 * 	echo " ... ";
	 * 	$phase->next();
	 * }
	 * echo "!!!!!";
	 * // ... ... ... !!!!!
	 * </code>
	 * 
	 * @return bool
	 */
	function hasNext() {
		return count($this->_phases) > $this->_current;
	}
}
/* ============================================================ *//**
 * c-shamoo router class
 * 
 * @package csr
 *//* ============================================================ */
class CSR {
	/**
	 * Get CSR variables
	 * 
	 * Usage
	 * <code>
	 * $vars = &CSR::getVars();
	 * var_dump($vars);
	 * </code>
	 * 
	 * @access public
	 * @return mixed
	 */
	function &getVars() {
		static $vars;
		return $vars;
	}
	/**
	 * Set CSR variable
	 * 
	 * 変数名(のようなもの)を指定して値を格納する。
	 * 
	 * Usage
	 * <code>
	 * $var = CSR::set('variable1', 'hoge');
	 * CSR::set('variable2', array('foo', 'bar'));
	 * </code>
	 * 
	 * @access public
	 * @param string variable name
	 * @param mixed variable
	 * @return mixed
	 */
	function &set($name, $var) {
		$vars = &CSR::getVars();
		$vars[$name] = &$var;
		return $var;
	}
	/**
	 * Get CSR variable
	 * 
	 * 変数名(のようなもの)を指定して、値を取得する。
	 * 
	 * Usage
	 * <code>
	 * $var = &CSR::get('variable1');
	 * if (CSR::get('boolean')) {some code..}
	 * </code>
	 * 
	 * @access public
	 * @param string variable name
	 * @return mixed
	 */
	function &get($name) {
		$vars = &CSR::getVars();
		return $vars[$name];
	}
	/**
	 * Define constant
	 * 
	 * @access public
	 * @param string define name
	 * @param string [optional] define value
	 * @return mixed defined string or null
	 */
	function define($defineName, $value = null) {
		if (!defined($defineName) && $value !== null) define($defineName, $value);
		return defined($defineName)? constant($defineName): null;
	}
	/**
	 * Execute CSR
	 * 
	 * <code>
	 * Usage
	 * CSR::execute($routeArray);
	 * </code>
	 * 
	 * @access public
	 * @param array routing array
	 * @return string rendered contents
	 */
	function execute($routes) {
		CSR::set('routes', $routes);
		if (!CSR::get('initialized')) CSR::initialize();
		CSR::runPhases();
		return CSR::get('content');
	}
	/**
	 * Initialize c-shamoo router
	 * 
	 * Usage
	 * <code>
	 * CSR::initialize();
	 * </code>
	 * 
	 * @access public
	 * @return void
	 */
	function initialize() {
		CSR::set('initialized', true);
		CSR::set('renderable', true);
		CSR::set('event', new CSR_EventObject());
		CSR::set('phase', new CSR_PhaseObject());
		CSR::set('dispatcher', new CSR_Dispatcher());
		CSR::set('modules', array());
		CSR::addEvent(EVENT_DISPATCH_ERROR, array('CSR', 'dispatchError'));
		
		// Add main phase
		CSR::addPhase(PHASE_APPLICATION_START, array('CSR_DefaultPhases', 'applicationStartPhase'));
		CSR::addPhase(PHASE_PARSE_ROUTE, array('CSR_DefaultPhases', 'parseRoutePhase'));
		CSR::addPhase(PHASE_ACTION, array('CSR_DefaultPhases', 'actionPhase'));
		CSR::addPhase(PHASE_RENDER, array('CSR_DefaultPhases', 'renderPhase'));
		CSR::addPhase(PHASE_OUTPUT, array('CSR_DefaultPhases', 'outputPhase'));
		CSR::addPhase(PHASE_APPLICATION_END, array('CSR_DefaultPhases', 'applicationEndPhase'));
	}
	/* ============================================================ *//*
	
		Event methods
		
	*//* ============================================================ */
	/**
	 * Add event method
	 * 
	 * Alias for eventObject->addEvent
	 * 
	 * Usage
	 * <code>
	 * 
	 * 
	 * 
	 * 
	 * 
	 * </code>
	 * 
	 * @param string event name
	 * @param mixed event handler
	 * @return void
	 */
	function addEvent($event, $handler) {
		$eventObject = &CSR::get('event');
		$eventObject->addEvent($event, $handler);
	}
	/**
	 * Remove event method
	 * 
	 * Alias for eventObject->removeEvnet
	 * 
	 * Usage
	 * <code>
	 * 
	 * 
	 * 
	 * 
	 * 
	 * </code>
	 * 
	 * @param string event name
	 * @param mixed event handler
	 * @return void
	 */
	function removeEvent($event, $handler) {
		$eventObject = &CSR::get('event');
		$eventObject->removeEvent($event, $handler);
	}
	/**
	 * Fire event method
	 * 
	 * Alias for eventObject->triggerEvent
	 * イベントハンドラに渡したい情報がある場合を除いて $param を設定する必要はありません。
	 * 
	 * Usage
	 * <code>
	 * 
	 * 
	 * 
	 * 
	 * 
	 * </code>
	 * 
	 * @param string event name
	 * @param array [optional] param for event handler
	 * @return void
	 */
	function triggerEvent($event, $params = array()) {
		$eventObject = &CSR::get('event');
		return $eventObject->triggerEvent($event, $params);
	}
	/* ============================================================ *//*
	
		Phase methods
		
	*//* ============================================================ */
	/**
	 * Add phase method
	 * 
	 * Alias for phaseObject->push
	 * 
	 * Usage
	 * <code>
	 * 
	 * </code>
	 * 
	 * @param string phase name
	 * @param mixed phase handler
	 * @param string [optional] phase name
	 */
	function addPhase($phase, $handler, $nextOf = null) {
		$phaseObject = &CSR::get('phase');
		$phaseObject->push($phase, $handler, $nextOf);
	}
	/**
	 * Remove phase method
	 * 
	 * Alias for phaseObject->delete
	 * 
	 * Usage
	 * <code>
	 * 
	 * </code>
	 * 
	 * @param $phase string
	 * @return void
	 */
	function removePhase($phase) {
		$phaseObject = &CSR::get('phase');
		$phaseObject->delete($phase);
	}
	/**
	 * フェイズ強制移動メソッド
	 * 
	 * 現在のフェイズの進行状況に関わらず、次に実行するフェイズを変更する
	 * 指定されたフェイズが存在しない場合、 false を返し、
	 * 正常にフェイズ移動ができた場合、 true を返す。
	 * おそらく期待した挙動をするためには、 phaseTo を呼んだ場合、それ以降そのメソッドの処理をさせない為に、
	 * すぐに return させる必要があることに注意。
	 * もしくはめんどくさいから return CSR::phaseTo() という文法で使う。
	 * あと、あたりまえだけど、自分が今いるフェイズよりも上に phaseTo した場合、
	 * また自分の番が来て、 上に phaseTo でループするので注意。
	 * まぁ正直 phaseTo は　CSR_PhaseObject に実装した方がいいんじゃないかって気もするけど微妙なところ
	 * 
	 * @param $phase string
	 * @param $params array
	 * 
	 * @return boolean
	 * 
	 * Usage
	 * return CSR::phaseTo('target_phase_name');
	 */
	function phaseTo($phase, $params = array()) {
		$phaseObject = &CSR::get('phase');
		return $phaseObject->moveTo($phase, $params);
	}
	/**
	 * フェイズ進行可能状況テストメソッド
	 * 
	 * Alias for phaseObject->hasNext
	 * 
	 * Usage
	 * <code>
	 * 
	 * </code>
	 * 
	 * @access public
	 * @return bool
	 */
	function hasNextPhase() {
		$phases = &CSR::get('phase');
		return $phases->hasNext();
	}
	/**
	 * Execute phase mehtod
	 * 
	 * CSRに登録されたフェイズをカレントフェイズから順に実行する。
	 * Alias for phaseObject->run
	 * 
	 * Usage
	 * <code>
	 * 
	 * </code>
	 * 
	 * @access public
	 * @return bool
	 */
	function runPhases() {
		$phases = &CSR::get('phase');
		return $phases->run();
	}
	/**
	 * Pause phase method
	 * 
	 * CSRノ実行中フェイズを停止する
	 * もうちょいテストが必要
	 * Alias for phaseObject->pause
	 * 
	 * Usage
	 * <code>
	 * 
	 * </code>
	 * 
	 * @access public
	 * @return void
	 */
	function pausePhases() {
		$phases = &CSR::get('phase');
		$phases->pause();
	}
	/* ============================================================ *//*
	
		Utilities
		
	*//* ============================================================ */
	/**
	 * モジュールインポートメソッド
	 * 
	 * MODULES_DIR に配置してあるモジュールをインポートする。
	 * 指定の方法は、
	 * MODULES_DIR/a/b/c/Foo.php
	 * というモジュールに対して
	 * a.b.c.Foo
	 * もしくは
	 * a.b.c.*
	 * という方法で指定する。
	 * 最後を * で指定した場合、そのディレクトリに含まれる全てのファイルを取得する。
	 * サブディレクトリは検索しない
	 * 
	 * ToDo
	 * モジュールが読み込めなかったとき、原因がわかりにくい
	 * 
	 * Usage
	 * <code>
	 * CSR::import('package.module.name');
	 * CSR::import('package.module.*');
	 * </code>
	 * 
	 * @param string package name
	 * @return void
	 */
	function import($package) {
		$loadedModules = &CSR::get('modules');
		if (isset($loadedModules[$package])) return;//$loadedModules[$package];
		
		$path = str_replace('.', '/', $package);
		if (basename($path) === '*') {
			$path = substr($path, 0, -1);
			if (is_dir(MODULES_DIR . $path) && ($dir = opendir(MODULES_DIR . $path))) {
				while(($entry = readdir($dir)) !== false) {
					if (!is_dir(MODULES_DIR . $path . $entry) && $entry{0} !== '.') {
						$package = str_replace('/', '.', $path . str_replace('.php', '', $entry));
						if (!CSR::_importModule($package)) trigger_error(sprintf('Failed import %s.', $package), E_USER_WARNING);
					}
				}
				closedir($dir);
			}
		} else {
			if (!CSR::_importModule($package)) trigger_error(sprintf('Failed import %s.', $package), E_USER_WARNING);
		}
	}
	/**
	 * モジュールを実インポートする
	 * 
	 * 正常に読み込めた場合、 true を返し、読み込めなかった場合、 false を返す。
	 * 
	 * Usage
	 * <code>
	 * CSR::_importModule('some.module.name');
	 * </code>
	 * 
	 * @access private
	 * @param string package name
	 * @return bool
	 */
	function _importModule($package) {
		$path = str_replace('.', '/', $package);
		if (!file_exists(MODULES_DIR . $path . '.php')) return false;
		// Load
		require_once MODULES_DIR . $path . '.php';

		// Loaded flag
		$loadedModules = &CSR::get('modules');
		$package = str_replace('/', '.', $path);
		$loadedModules[$package] = true;
		return true;
	}
	/* ============================================================ *//*
	
		Error handlers
		
	*//* ============================================================ */
	/**
	 * クライアントエラーメソッド
	 * 
	 * 何らかのエラーによりクライアントエラーが発生した場合、
	 * エラーヘッダを出力し、エラーボディーをセットし、フェイズを 出力 に移動する。
	 * 
	 * 実際にクライアントエラー場面に遭遇した場合、このメソッドを直接呼ぶのではなく、
	 * CSR::triggerEvent(EVENT_DISPATCH_ERROR);
	 * などの方法で呼ぶと、他のエラー処理などとまとめて実行できる為、都合が良い。
	 * 
	 * Usage
	 * <code>
	 * CSR::addEvent(EVENT_DISPATCH_ERROR, array('CSR', 'dispatchError'))
	 * </code>
	 * 
	 * @access public
	 * @param string event name
	 * @param array event params
	 * @return mixed event result
	 */
	function dispatchError($event, $params) {
		switch ($params['status']) {
			case 400: $status = '400 Bad Request'; break;
			case 401: $status = '401 Unauthorized'; break;
			case 402: $status = '402 Payment Required'; break;
			case 403: $status = '403 Forbidden'; break;
			case 404: $status = '404 Not Found'; break;
			case 405: $status = '405 Method Not Allowed'; break;
			case 406: $status = '406 Not Acceptable'; break;
			case 407: $status = '407 Proxy Authentication Required'; break;
			case 408: $status = '408 Request Timeout'; break;
			case 409: $status = '409 Conflict'; break;
			case 410: $status = '410 Gone'; break;
		}
		$status = 'HTTP/1.1 '. $status;
		header($status);
		if (isset($params['message'])) $debugMessage = array(
			sprintf('<p>%s</p>', htmlspecialchars($params['message'], ENT_QUOTES))
		);
		if (isset($params['type'])) $debugHelpFile = ERRORS_DIR . 'debug/' . strtolower($params['type']) . '.php';
		ob_start();
		require ERRORS_DIR . $params['status'] . '.php';
		CSR::set('content', ob_get_clean());
		CSR::phaseTo(PHASE_OUTPUT);
		return $params['status'];
	}
	
	/**
	 * @access private
	 */
	function debugMessage($message) {
		if (CSR_DEVELOP_MODE) echo $message;
	}
}
/* ============================================================ *//**
 * c-shamoo router routing engine
 * 
 * @package csr
 *//* ============================================================ */
class CSR_Dispatcher extends CSR_Object {
	/**
	 * @var array
	 * @access private
	 */
	var $_routes = array();
	/**
	 * @var array 
	 * @access private
	 */
	var $_parsed = array();
	/**
	 * @var string
	 * @access public
	 */
	var $request = '';
	/**
	 * Construct
	 * 
	 * @access public
	 * @param array [optional] routes
	 */
	function __construct($routes = array()) {
		parent::__construct();
		$this->_routes = $routes;
	}
	/**
	 * Push route method
	 * 
	 * @access public
	 * @param string routing string
	 * @param string target string
	 * @return int routes length
	 */
	function push($route, $target) {
		if (isset($this->_routes[$route])) unset($this->_routes[$route]);
		$this->_routes[$route] = $target;
		return count($this->_routes);
	}
	/**
	 * Set route method
	 * 
	 * @access public
	 * @param array routes
	 * @return void
	 */
	function setRoute($routes) {
		$this->_routes = $routes;
	}
	
	function getRoutes() {
		return $this->_routes;
	}
	/**
	 * Parse request method
	 * 
	 * request から routes を走査し、
	 * 適合した route を返す。
	 * 
	 * @access public
	 * @param string request uri
	 * @return array parsed params
	 */
	function parseRequest($request) {
		$request = $this->_requestOptimize($request);
		$parsedGetVars = $this->_parseGetVars($request);
		$this->request = $parsedGetVars['request'];
		if (isset($parsedGetVars['getVars'])) {
			$this->_parsed['getVars'] = $parsedGetVars['getVars'];
		} else $this->_parsed['getVars'] = array();
		foreach ($this->_routes as $path => $route) {
			/*
			 * Extension
			 */
			$original = $path;
			if (strpos($path, '@') !== false) {
				list($path, $extension) = explode('@', $path);
				$extension = '\.' . $extension;
			} else $extension = '';
			$regex = $path;
			/*
			 * Arguments
			 */
			$regex = $this->_wildToRegex(':num', $regex, '[0-9]+');
			$regex = $this->_wildToRegex(':any', $regex, '[A-Za-z0-9_-]+');
			/*
			 * Default
			 */
			$regex = str_replace(':controller', '(?P<controller>[a-zA-Z][a-zA-Z0-9_-]+)', $regex);
			$regex = str_replace(':action', '(?P<action>[a-zA-Z_][a-zA-Z0-9_-]+)', $regex);
			$matches = array();
			/*
			 * Match!
			 */
			if (preg_match('#^' . $regex . $extension . '$#', $this->request, $matches)) {
				$this->_parsed['matchedRequestRegex'] = $regex . $extension;
				$this->_parsed['matchedRoute'] = array($original => $route);
				
				$capturesArray = array();
				$argumentsArray = array();
				$nextIsPair = false;
				while ($match = each($matches)) {
					if (!is_int($match['key'])) {
						$nextIsPair = true;
						// Controller
						if ($match['key'] === 'controller') {
							$route = str_replace(':controller', $match['value'], $route);
							continue;
						}
						// Action
						if ($match['key'] === 'action') {
							$route = str_replace(':action', $match['value'], $route);
							continue;
						}
						// Arguments
						$argumentsArray[] = $match['value'];
						continue;
					}
					// Regex captures
					if (!$nextIsPair) {
						$capturesArray[] = $match['value'];
						$nextIsPair = false;
					}
				}
				// Fix controller|action $x
				foreach ($capturesArray as $index => $r) {
					$route = str_replace('$' . $index, $r, $route);
				}
				
				$this->_parsed['target'] = $route;
				$this->_parsed['captured'] = $capturesArray;
				$this->_parsed['arguments'] = $argumentsArray;
				
				$this->_parsed['extension'] = ltrim((strpos($matches[0], '.') === false)? null: substr($matches[0], strpos($matches[0], '.')), '.');
				return $this->_parsed;
				break;
			}
		}
	}
	/**
	 * Request optimize method
	 * 
	 * @access private
	 * @param string reuest strings
	 * @return string optimized request strings
	 */
	function _requestOptimize($request) {
		/*
		 * Delete basedir span from request
		 */
		$baseDir = dirname($_SERVER['SCRIPT_NAME']);
		if ($baseDir != '') {
			$request = substr_replace($request, '', strpos($request, $baseDir), strlen($baseDir));
		}
		/*
		 * If disable mod_rewrite
		 */
		if (strpos($request, '/?') === 0) {
			$request = $_SERVER['QUERY_STRING'];
		}
		/*
		 * Request first character must be "/"
		 */
		if ($request{0} !== '/') {
			$request = '/' . $request;
		}
		return $request;
	}
	/**
	 * Divide parameter and request from request
	 * 
	 * @access private
	 * @param string get variables include rquest
	 * @return array devided request
	 */
	function _parseGetVars($request) {
		if (strpos($request, '?') !== false || strpos($request, '&') !== false) {
			$getVars = array();
			$requests = explode('?', $request);
			$request = $requests[0];
			
			$getParams = explode('&', $requests[1]);
			foreach ($getParams as $var) {
				list($name, $val) = explode('=', $var);
				$getVars[$name] = $val;
			}
		}
		$r = array('request' => $request);
		if (isset($getVars) && count($getVars) > 0) $r['getVars'] = $getVars;
		return $r;
	}
	
	function _wildToRegex($wild, $subject, $replaceRegExp) {
		static $i = 0;
		if (strpos($subject, $wild) !== false) {
			$subject = substr_replace($subject, sprintf('(?P<arg%s>%s)', $i++, $replaceRegExp), strpos($subject, $wild), strlen($wild));
			$subject = $this->_wildToRegex($wild, $subject, $replaceRegExp);
		}
		return $subject;
	}
	/**
	 * Get parsed parameters
	 * 
	 * Usage
	 * <code>
	 * $dispatcher = &new CSR_Dispatcher(array(
	 * 	'/foo/bar/:num/:num/([a-zA-Z])/(.?.ml)/:any@html' => 'foobar',
	 * 	'/' => '/index.php'
	 * ));
	 * $dispatcher->parseRequest('/csr1.0/foo/bar/123/4567/c/html/some_file_name.html?item=1255&color=0xf6d4e9');
	 * var_dump($dispatcher->getParsedParams());
	 * // array(7) {
	 * //   ["getVars"]=>
	 * //   array(2) {
	 * //     ["item"]=>
	 * //     string(4) "1255"
	 * //     ["color"]=>
	 * //     string(8) "0xf6d4e9"
	 * //   }
	 * //   ["matchedRequestRegex"]=>
	 * //   string(68) "/foo/bar/([0-9]+)/([0-9]+)/([a-zA-Z])/(.?.ml)/([A-Za-z0-9_-]+)\.html"
	 * //   ["matchedRoute"]=>
	 * //   array(1) {
	 * //     ["/foo/bar/:num/:num/([a-zA-Z])/(.?.ml)/:any@html"]=>
	 * //     string(6) "foobar"
	 * //   }
	 * //   ["arguments"]=>
	 * //   array(3) {
	 * //     [0]=>
	 * //     string(3) "123"
	 * //     [1]=>
	 * //     string(4) "4567"
	 * //     [2]=>
	 * //     string(14) "some_file_name"
	 * //   }
	 * //   ["captured"]=>
	 * //   array(3) {
	 * //     [0]=>
	 * //     string(44) "/foo/bar/123/4567/c/html/some_file_name.html"
	 * //     [1]=>
	 * //     string(1) "c"
	 * //     [2]=>
	 * //     string(4) "html"
	 * //   }
	 * //   ["target"]=>
	 * //   string(6) "foobar"
	 * //   ["extension"]=>
	 * //   string(4) "html"
	 * // }
	 * </code>
	 * 
	 * @access public
	 * @return array GET parameters
	 */
	function getParsedParams() {
		return $this->_parsed;
	}
	/**
	 * Get GET request parameters
	 * 
	 * Usage
	 * <code>
	 * $dispatcher = &new CSR_Dispatcher(array(
	 * 	'/foo/bar/:num/:num/([a-zA-Z])/(.?.ml)/:any@html' => 'foobar',
	 * 	'/' => '/index.php'
	 * ));
	 * $dispatcher->parseRequest('/foo/bar/123/4567/c/html/some_file_name.html?item=1255&color=0xf6d4e9');
	 * var_dump($dispatcher->getGetParams());
	 * // array(2) {
	 * //   ["item"]=>
	 * //   string(4) "1255"
	 * //   ["color"]=>
	 * //   string(8) "0xf6d4e9"
	 * // }
	 * </code>
	 * 
	 * @access public
	 * @return array GET parameters
	 */
	function getGetParams() {
		return $this->_parsed['getVars'];
	}
	/**
	 * Get arguments
	 * 
	 * Usage
	 * <code>
	 * $dispatcher = &new CSR_Dispatcher(array(
	 * 	'/foo/bar/:num/:num/([a-zA-Z])/(.?.ml)/:any@html' => 'foobar',
	 * 	'/' => '/index.php'
	 * ));
	 * $dispatcher->parseRequest('/foo/bar/123/4567/c/html/some_file_name.html?item=1255&color=0xf6d4e9');
	 * var_dump($dispatcher->getArguments());
	 * // array(3) {
	 * //   [0]=>
	 * //   string(3) "123"
	 * //   [1]=>
	 * //   string(4) "4567"
	 * //   [2]=>
	 * //   string(14) "some_file_name"
	 * // }
	 * </code>
	 * 
	 * @access public
	 * @return array arguments
	 */
	function getArguments() {
		return $this->_parsed['arguments'];
	}
	/**
	 * Get captures
	 * 
	 * Usage
	 * <code>
	 * $dispatcher = &new CSR_Dispatcher(array(
	 * 	'/foo/bar/:num/:num/([a-zA-Z])/(.?.ml)/:any@html' => 'foobar',
	 * 	'/' => '/index.php'
	 * ));
	 * $dispatcher->parseRequest('/csr1.0/foo/bar/123/4567/c/html/some_file_name.html?item=1255&color=0xf6d4e9');
	 * var_dump($dispatcher->getCaptures());
	 * // array(3) {
	 * //   [0]=>
	 * //   string(44) "/foo/bar/123/4567/c/html/some_file_name.html"
	 * //   [1]=>
	 * //   string(1) "c"
	 * //   [2]=>
	 * //   string(4) "html"
	 * // }
	 * </code>
	 * 
	 * @access public
	 * @return array captured values
	 */
	function getCaptures() {
		return $this->_parsed['captured'];
	}
	/**
	 * Get target
	 * 
	 * Usage
	 * <code>
	 * $dispatcher = &new CSR_Dispatcher(array(
	 * 	'/foo/bar/:num/:num/([a-zA-Z])/(.?.ml)/:any@html' => 'foobar',
	 * 	'/' => '/index.php'
	 * ));
	 * $dispatcher->parseRequest('/csr1.0/foo/bar/123/4567/c/html/some_file_name.html?item=1255&color=0xf6d4e9');
	 * var_dump($dispatcher->getTarget());
	 * // string(6) "foobar"
	 * </code>
	 * 
	 * @access public
	 * @return mixed parsed target
	 */
	function getTarget() {
		return $this->_parsed['target'];
	}
	/**
	 * Get extension
	 * 
	 * Usage
	 * <code>
	 * $dispatcher = &new CSR_Dispatcher(array(
	 * 	'/foo/bar/:num/:num/([a-zA-Z])/(.?.ml)/:any@html' => 'foobar',
	 * 	'/' => '/index.php'
	 * ));
	 * $dispatcher->parseRequest('/csr1.0/foo/bar/123/4567/c/html/some_file_name.html?item=1255&color=0xf6d4e9');
	 * var_dump($dispatcher->getExtension());
	 * // string(4) "html"
	 * </code>
	 * 
	 * @access public
	 * @return string extension
	 */
	function getExtension() {
		return $this->_parsed['extension'];
	}
}

class CSR_Model extends CSR_Object {
	
	function find() {}
	function save() {}
	function delete() {}
}

class CSR_View extends CSR_Object {
	var $_content = '';
	var $_layouts = array();
	var $_defaultLayouts = array();
	var $_shortcuts = array();
	function __construct() {
		parent::__construct();
		$this->_defaultLayouts = array(
			'_layout',
			CSR::get('actionName')
		);
	}
	
	function render($layout = null) {
		if (!is_null($layout)) $this->_layouts = $layout;
		if (is_null($this->_layouts)) return;
		reset($this->_layouts);
		ob_start();
		$this->content();
		$this->_content = ob_get_clean();
		return $this->_content;
	}
	/**
	 * 次のテンプレートを読み込む
	 * 
	 * 
	 * 
	 * 
	 * 
	 * 
	 * 
	 * 
	 * 
	 */
	function content() {
		if (empty($this->_layouts)) {
			if (CSR_DEVELOP_MODE)
				trigger_error('There are not contents to render.', E_USER_WARNING);
			return;
		}
		// Shortcuts
		foreach ($this->_shortcuts as $shortcut => $value) {
			$$shortcut = $this->$value;
		}
		$file = each($this->_layouts);
		require_once $file['value'];
	}
	
	function parseLayouts($layouts) {
		if (empty($layouts)) return;
		$tempLayouts = array();
		$targetController = CSR::get('controllerName');
		$viewsDirWithControllerName = VIEWS_DIR . $targetController . '/';
		$layouts = explode('/', $layouts);
		$layoutsLength = count($layouts);
		CSR::define('VIEW_FILE_EXTENSION', '.html');
		for ($i = 0; $i < $layoutsLength; $i++) {
			$layout = $layouts[$i];
			if ($layout === '') continue;
			if ($layout === '*') $layout = $this->_defaultLayouts[$i];
			if (file_exists($viewsDirWithControllerName . $layout . VIEW_FILE_EXTENSION)) {
				$layoutPath = $viewsDirWithControllerName . $layout . VIEW_FILE_EXTENSION;
			} else if (file_exists($layout . VIEW_FILE_EXTENSION)) {
				$layoutPath = $layout . VIEW_FILE_EXTENSION;
			} else {
				if (CSR_DEVELOP_MODE) {
					if ($layout{0} === '/' || $layout{0} === '.') {
						trigger_error(sprintf('Target view file <em>%s</em> does not exist.', realpath($layout . VIEW_FILE_EXTENSION)), E_USER_WARNING);
						continue;
					} else {
						trigger_error(sprintf('Target view file <em>%s</em> does not exist.', $viewsDirWithControllerName . $layout . VIEW_FILE_EXTENSION), E_USER_WARNING);
						continue;
					}
				} else continue;
			}
			$tempLayouts[] = $layoutPath;
		}
		return $tempLayouts;
	}
	
	function setLayouts($layouts) {
		$this->_layouts = $this->parseLayouts($layouts);
	}
}

class CSR_Controller extends CSR_Object {
	var $view;
	var $layout = '*/*';
	function __construct() {
		parent::__construct();
		$this->view = &CSR::get('view');
	}
	
	function _executeAction($action, $arguments = array()) {
		if (!method_exists($this, $action)) return false;
		$useView = call_user_func_array(array(&$this, $action), $arguments);
		if ($useView === false) $this->layout = '';
		$this->view->setLayouts($this->layout);
		return true;
	}
	
	function set($varName, $vars = '', $shortcut = null) {
		$this->view->$varName = $vars;
		if (!$shortcut !== null) {
			$this->shortcut($shortcut, $varName);
		}
	}
	
	function shortcut($shortcut, $var) {
		$this->view->_shortcuts[$shortcut] = $var;
	}
	
	function redirectTo() {
		
	}
	function beforeAction() {}
	function afterAction() {}
	function beforeRender() {}
	function afterRender() {}
	
	// モデルを読み込む
	function useModel($modelPath) {
		require MODELS_DIR . $modelPath . '.php';
	}
	
	function loadController($name) {
		$controllerClassName = ucwords($name) . 'Controller';
		$appControllerPath = sprintf('%s%s', APP_CONTROLLER_DIR, APP_CONTROLLER_FILE_NAME);
		$controllerPath = sprintf('%s%s', CONTROLLERS_DIR, $controllerClassName . '.php');
		if (!file_exists($appControllerPath) || !file_exists($controllerPath)) return null;
		require_once $appControllerPath;
		require_once $controllerPath;
		return $controllerClassName;
	}
	
	function _missingController() {
		return CSR::triggerEvent(EVENT_DISPATCH_ERROR, array(
			'status' => 404,
			'message' => 'Missing controller.',
			'type' => 'MISSING_CONTROLLER'
		));
	}
	
	function _privateAction() {
		return CSR::triggerEvent(EVENT_DISPATCH_ERROR, array(
			'status' => 404,
			'message' => 'Private action.',
			'type' => 'PRIVATE_ACTION'
		));
	}
	
	function _undefinedAction() {
		return CSR::triggerEvent(EVENT_DISPATCH_ERROR, array(
			'status' => 404,
			'message' => 'Undefined action.',
			'type' => 'UNDEFINED_ACTION'
		));
	}
}
/* ============================================================ *//**
 * c-shamoo router default phases class
 * 
 * @package csr
 *//* ============================================================ */
class CSR_DefaultPhases {
	function parseRoutePhase() {
		$dispatcher = &CSR::get('dispatcher');
		$dispatcher->setRoute(CSR::get('routes'));
		/*
		 * Add default route
		 */
		$dispatcher->push('/:controller/:action', ':controller/:action');
		CSR::triggerEvent(EVENT_BEFORE_PARSE_ROUTE);
		$parsedRequest = $dispatcher->parseRequest($_SERVER['REQUEST_URI']);
		CSR::triggerEvent(EVENT_AFTER_PARSE_ROUTE);
		if ($parsedRequest === null)
			return CSR::triggerEvent(EVENT_DISPATCH_ERROR, array(
				'status' => 404,
				'message' => 'Dispatch error.',
				'type' => 'DISPATCH_ERROR'
			));
	}
	
	function actionPhase() {
		$dispatcher = &CSR::get('dispatcher');
		$parsed = $dispatcher->getParsedParams();
		switch (true) {
			case $parsed['target']{0} === '/':
				CSR::addPhase(PHASE_ACTION, array('CSR_DefaultPhases', 'fileActionPhase'));
			break;
			case (PHP_OS === 'WIN32' || PHP_OS === 'WINNT') && preg_match('#^[a-zA-Z]+:#', $parsed['target']) > 0:
				CSR::addPhase(PHASE_ACTION, array('CSR_DefaultPhases', 'fileActionPhase'));
			break;
			case strpos($parsed['target'], '://') !== false:
				CSR::addPhase(PHASE_ACTION, array('CSR_DefaultPhases', 'urlActionPhase'));
			break;
			case strpos($parsed['target'], '/') !== false:
				CSR::addPhase(PHASE_ACTION, array('CSR_DefaultPhases', 'mvcActionPhase'));
			break;
			default:
				CSR::addPhase(PHASE_ACTION, array('CSR_DefaultPhases', 'unknownActionPhase'));
		}
		// Retry action phase
		CSR::phaseTo(PHASE_ACTION);
	}
	
	function renderPhase() {
		$view = &CSR::get('view');
		CSR::triggerEvent(EVENT_BEFORE_RENDER);
		CSR::set('content', $view->render());
		CSR::triggerEvent(EVENT_AFTER_RENDER);
	}
	function outputPhase() {
		CSR::triggerEvent(EVENT_BEFORE_OUTPUT);
		if (CSR::get('renderable')) echo CSR::get('content');
		CSR::triggerEvent(EVENT_AFTER_OUTPUT);
	}
	function applicationStartPhase() {
		CSR::triggerEvent(EVENT_APPLICATION_START);
	}
	function applicationEndPhase() {
		CSR::triggerEvent(EVENT_APPLICATION_END);
	}
	function fileActionPhase() {
		$dispatcher = &CSR::get('dispatcher');
		$target = $dispatcher->getTarget();
		if (!file_exists($target)) return CSR::triggerEvent(EVENT_DISPATCH_ERROR, array(
			'status' => 404,
			'message' => 'File action missing.',
			'type' => 'FILE_ACTION_MISSING'
		));
		ob_start();
		require $target;
		CSR::set('content', ob_get_clean());
		CSR::phaseTo(PHASE_OUTPUT);
	}
	
	function urlActionPhase() {
		echo "This is URL_ACTION_PHASE. set not yet.";
	}
	
	function mvcActionPhase() {
		$dispatcher = &CSR::get('dispatcher');
		$parsed = $dispatcher->getParsedParams();
		list($targetController, $targetAction) = explode('/', $parsed['target']);
		CSR::set('controllerName', $targetController);
		CSR::set('actionName', $targetAction);
		$arguments = (isset($parsed['arguments']))? $parsed['arguments']: null;
		if (!$controllerClassName = CSR_Controller::loadController($targetController)) return CSR_Controller::_missingController();
		// Private action
		if ($targetAction{0} === '_') return CSR_Controller::_privateAction();
		$view = &CSR::set('view', new CSR_View());
		$controller = &CSR::set('controller', new $controllerClassName());
		CSR::addEvent(EVENT_BEFORE_ACTION, array(&$controller, 'beforeAction'));
		CSR::addEvent(EVENT_AFTER_ACTION, array(&$controller, 'afterAction'));
		CSR::addEvent(EVENT_BEFORE_RENDER, array(&$controller, 'beforeRender'));
		CSR::addEvent(EVENT_AFTER_RENDER, array(&$controller, 'afterRender'));
		// Execute action
		CSR::triggerEvent(EVENT_BEFORE_ACTION);
		if (!$controller->_executeAction($targetAction, $arguments)) return CSR_Controller::_undefinedAction();
		CSR::triggerEvent(EVENT_AFTER_ACTION);
	}
	
	function unknownActionPhase() {
		echo "This is unknown_ACTION_PHASE. set not yet.";
	}
}
CSR::initialize();

