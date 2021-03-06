<?php
/**
* View zum Listen mehrerer Events
*
* @category   Veranstaltungsmanager
* @package    Admin
* @subpackage View
*/

// Direkten Zugriff verhindern
defined('_JEXEC') or die('Restricted access');

// Joomla View laden
jimport('joomla.application.component.view');

/**
* View zum Listen mehrerer Events
*
* @category   Veranstaltungsmanager
* @package    Admin
* @subpackage View
*/
class EventsViewEvents extends JViewLegacy {
	/**
	*  Ausführung und Anzeige des Template-Skripts
	*
	* @return void
	*/
	function display($tpl = null) {
		// Daten vom Events-Model laden
		$this->items = $this->get('Items');
		
		// Pagination laden
		$this->pagination = $this->get('Pagination');
		
		// Toolbar hinzufügen
		$this->addToolBar();
		
		// Template anzeigen
		parent::display($tpl);
		
		// Auf Fehler prüfen und ausgeben.
		if(count($errors = $this->get('Errors'))) {
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}
		
		// Setzen einiger Dokumenten-Details (z.B. JavaScript, Titel)
		$this->setDocument();
	}
	
	/**
	* Hinzufügen der Toolbar
	*
	* @return void
	*/
	protected function addToolBar() {
		// Objekt zum Überprüfen der Berechtigungen für ein Element
		$canDo = EventsHelper::getActions();
		
		// Setze Titel der Toolbar
		JToolBarHelper::title(JText::_('COM_EVENTS_MANAGER_EVENTS'), 'events');
		
		// Setze abhängig von Zugriffsrechten des Benutzers die Buttons
		if($canDo->get('core.create')) {
			JToolBarHelper::addNew('event.add', 'JTOOLBAR_NEW');
		}
		if($canDo->get('core.edit')) {
			JToolBarHelper::editList('event.edit', 'JTOOLBAR_EDIT');
		}
		if($canDo->get('core.delete')) {
			JToolBarHelper::deleteList('', 'events.delete', 'JTOOLBAR_DELETE');
		}
		if($canDo->get('core.admin')) {
			JToolBarHelper::divider();
			JToolBarHelper::preferences('com_events');
		}
	}
	
	/**
	* Methode zum Setzen der Dokumenteneinstellungen
	*
	* @return void
	*/
	protected function setDocument() {
		// Hole aktuelles Dokument und setze Titel
		JFactory::getDocument()->setTitle(JText::_('COM_EVENTS_ADMINISTRATION'));
	}
}
