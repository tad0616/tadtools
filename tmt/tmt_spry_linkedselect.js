/** 
* Copyright 2008 massimocorner.com
* License: http://www.massimocorner.com/license.htm
* @author      Massimo Foti (massimo@massimocorner.com)
* @version     0.5.1, 2008-05-11
* @require     tmt_core.js
 */
 
if((typeof(tmt) == "undefined")){
	alert("Error: tmt.core JavaScript library missing");
}

if(typeof(tmt.spry) == "undefined"){
	tmt.spry = {};
}

tmt.spry.linkedselect = {};

// Create all the spry_select objects required inside the document
tmt.spry.linkedselect.init = function(){
	var selectNodes = document.getElementsByTagName("select");
	var spryNodes = tmt.filterNodesByAttribute("tmt:linkedselect", selectNodes);
	for(var i=0; i<spryNodes.length; i++){
			// Attach a spry_select object to each node that requires it
			spryNodes[i].tmtSpryLinkedSelect = tmt.spry.linkedselect.factory(spryNodes[i]);
			// Call spry_select's handler after onchange
			tmt.addEvent(spryNodes[i], "change", spryNodes[i].tmtSpryLinkedSelect.onchangeHandler);
	}
}

// Please note, direct call to this object aren't supported
// You should only use the tmt.spry.linkedselect.util's API instead
tmt.spry.linkedselect.factory = function(selectNode){
	var obj = {};
	obj.selectNode = selectNode;
	obj.dataset = null;
	obj.datasetLoaded = false;
	obj.datasetRows = [];
	// Store the target <select> id (if any)
	obj.targetId = null;
	if(obj.selectNode.getAttribute("tmt:targetselect")){
		obj.targetId = obj.selectNode.getAttribute("tmt:targetselect");
	}
	// Store the value that will trigger reset (if any)
	obj.resetOnValue = null;
	if(obj.selectNode.getAttribute("tmt:resetonvalue") != null){
		obj.resetOnValue = obj.selectNode.getAttribute("tmt:resetonvalue");
	}
	// By default the <select> is populated as soon as the dataset send a notification
	obj.autoLoad = true;
	if(obj.selectNode.getAttribute("tmt:autoload")){
		obj.autoLoad = eval(obj.selectNode.getAttribute("tmt:autoload"));
	}
	// By default any call to the update method overwrite any <option> available inside the XHTML
	// This behavior can be prevented by using tmt:overwrite="false" 
	obj.overwrite = true;
	if(obj.selectNode.getAttribute("tmt:overwrite")){
		obj.overwrite = eval(obj.selectNode.getAttribute("tmt:overwrite"));
	}
	obj.defaultOptions = [];
	for(var j=0; j<obj.selectNode.options.length; j++){
		var tempObj = new Option();
		tempObj.value = obj.selectNode.options[j].value;
		tempObj.text = obj.selectNode.options[j].text;
		obj.defaultOptions.unshift(tempObj);
	}

	// Add an option using text and value
	obj.addOption = function(text, value){
		// Value is optional, if missing use text
		if(!value){
			value = text;
		}
		obj.selectNode.options[obj.getLength()] = new Option(text, value);
	}

	// Remove all the options
	obj.clean = function(){
		obj.selectNode.innerHTML = "";
	}

	// Delete a set of options. If no set is passed, delete the currently selected options (support multiple)
	obj.deleteOptions = function(indexesArray){
		if(!indexesArray){
			indexesArray = obj.getSelectedIndexes();
		}
		var offset = 0;	
		for(var i=0; i<indexesArray.length; i++){
			obj.selectNode.options[indexesArray[i]-offset] = null;
			offset++;
		}
	}

	// Given a value, return its index, return -1 if the value isn't available
	obj.getIndexFromValue = function(value){
		for(var i=0; i<obj.selectNode.options.length; i++){
			if(obj.selectNode.options[i].value == value){
				return i;
			}
		}
		return -1;
	}

	// Return the index of currently selected option, -1 if nothing is selected
	obj.getIndex = function(){
		return obj.selectNode.selectedIndex;
	}

	// Return the amount of options
	obj.getLength = function(){
		return obj.selectNode.options.length;
	}

	// Return the relevant option for a given index
	obj.getOption = function(optionIndex){
		return obj.selectNode.options[optionIndex];
	}

	// Get the current value (no multiple support)
	obj.getValue = function(){
		return obj.selectNode.value;
	}

	// Get the indexes of all the selected options as an array (support multiple)
	obj.getSelectedIndexes = function(){
		var selectedIndexes = [];
		for(var i=0; i<obj.selectNode.options.length; i++){
			if(obj.selectNode.options[i].selected){
				selectedIndexes.push([i]);
			}
		}
		return selectedIndexes;
	}

	// Get a copy of all the selected options inside an array (support multiple)
	obj.getSelectedOptions = function(){
		var selectedOptions = [];
		for(var i=0; i<obj.selectNode.options.length; i++){
			if(obj.selectNode.options[i].selected){
				selectedOptions.push(obj.selectNode.options[i]);
			}
		}
		return selectedOptions;
	}

	// Load and display options extracting data from a given array of rows
	obj.loadData = function(inputData){
		if(!inputData){
			inputData = obj.datasetRows;
		}
		for(var i=0; i<inputData.length; i++){
			obj.addOption(inputData[i][obj.textField], inputData[i][obj.valueField]);
		}
	}

	// Load and display the options from a Spry dataset
	obj.loadDataset = function(dataset){
		// Avoid loading data if we get called by multiple observer notifications
		if(obj.datasetLoaded == false){
			obj.datasetRows = dataset.data;
			obj.loadData(dataset.data);
			obj.datasetLoaded = true;
			obj.setDefaultSelected();
		}
	}

	// Load again <option> that were definied inside XHTML code
	obj.loadDefaultOptions = function(){
		for(var i=0; i<obj.defaultOptions.length; i++){
			obj.addOption(obj.defaultOptions[i].text, obj.defaultOptions[i].value);
		}
	}

	// Callback for onchange event
	obj.onchangeHandler = function(){
		if(obj.targetId){
			// Check if, given the current selection, we need to reset
			var doReset = (obj.resetOnValue != null) && (obj.getValue() == obj.resetOnValue);
			var targetObj = tmt.spry.linkedselect.util.getObjFromId(obj.targetId);
			if(doReset){
				// Reset only the target <select>
				// If the target <select> doesn't autoload, reset means we only show hardcoded values
				if(targetObj.autoLoad == true){
					targetObj.resetDefault();
				}
				targetObj.onchangeHandler();
			}
			else{
				// Filter the target <select>
				targetObj.filter(obj.valueField, obj.getValue());
			}
		}
	}

	// Filter the dataset based on field name and value
	obj.filter = function(fieldName, fieldValue){
		var retArray = [];
		for(var j=0; j<obj.dataset.data.length; j++){
			var rowValue = obj.dataset.data[j][fieldName];
			if(rowValue != fieldValue){
				continue;
			}
			retArray.push(obj.dataset.data[j]);
		}
		obj.update(retArray);
	}

	// This gets called by the Spry's dataset as soon as data is changed
	obj.onDataChanged = function(dataset){
		obj.loadDataset(dataset);
	}

	// Move selected options down by a position (support multiple)
	obj.optionsDown = function(){
		var indexes = obj.getSelectedIndexes();
		indexes.reverse();
		// If the last option is selected, abort
		if(indexes[0] == (obj.getLength() -1)){
			return;
		}
		for(var i=0; i<indexes.length; i++){
			obj.swapOptions(indexes[i], (parseInt(indexes[i]) +1));
		}
	}

	// Move selected options up by a position (support multiple)
	obj.optionsUp = function(){
		var indexes = obj.getSelectedIndexes();
		// If the first option is selected, abort
		if(indexes[0] == 0){
			return;
		}
		for(var i=0; i<indexes.length; i++){
			obj.swapOptions(indexes[i], (indexes[i] -1));
		}
	}

	// Clean the options, then load only hardcoded data
	obj.removeBinding = function(){
		obj.clean();
		for(var i=0; i<obj.defaultOptions.length; i++){
			obj.addOption(obj.defaultOptions[i].text, obj.defaultOptions[i].value);
		}
	}

	// Reset default options
	obj.resetDefault = function(){
		// Clean the options then load default data
		obj.clean();
		obj.loadDefaultOptions();
		if(obj.dataset){
			// Reload current dataset
			obj.datasetLoaded = false;
			obj.loadDataset(obj.dataset);
		}
	}

	// Select the option matching a given value (if any)
	obj.selectValue = function(optionValue){
		obj.selectNode.selectedIndex = obj.getIndexFromValue(optionValue);
	}

	// Switch binding to a new dataset
	obj.setBinding = function(newDataset){
		// Reset instance variables
		obj.datasetLoaded = false;
		obj.dataset = newDataset;
		obj.update(newDataset.data);
	}

	// Set the default selected option, as specified inside the tmt:defaultselected attribute
	obj.setDefaultSelected = function(){
		if(obj.selectNode.getAttribute("tmt:defaultselected")){
			var optionValue = obj.selectNode.getAttribute("tmt:defaultselected");
			obj.selectValue(optionValue);
		}
	}

	// Sort the options based on their text
	obj.sortOptions = function(){
		var sortedArray = new Array();
		var currentOptions = obj.selectNode.options;
		// Copy the elements inside the new array
		for (var i=0; i<currentOptions.length; i++){
			sortedArray.push(new Option(currentOptions[i].text, currentOptions[i].value, currentOptions[i].defaultSelected, currentOptions[i].selected));
		}
		// Sort the elements based on their text
		sortedArray.sort(
			function(a, b){
				if((a.text.toUpperCase()) < (b.text.toUpperCase())){
					return -1;
				}
				if((a.text.toUpperCase()) > (b.text.toUpperCase())){
					return 1;
				}
				return 0;
			}
		)
		// Overwrite current options
		for(var k=0; k<sortedArray.length; k++){
			obj.selectNode.options[k] = sortedArray[k];
		}
	}

	// Swap the position of two options
	obj.swapOptions = function(from, to){
		var temp1 = obj.getOption(from);
		var temp2 = obj.getOption(to);
		obj.selectNode.options[to] = new Option(temp1.text, temp1.value, temp1.defaultSelected, temp1.selected);
		obj.selectNode.options[from] = new Option(temp2.text, temp2.value, temp2.defaultSelected, temp2.selected);
	}

	// Update the options based on a given array of rows
	obj.update = function(newData){
		// Clean the options, then load new ones
		obj.datasetRows = newData;
		obj.clean();
		if(obj.overwrite == false){
			obj.loadDefaultOptions();
		}
		obj.loadData(newData);
		// Update any target <select>
		obj.onchangeHandler();
	}

	// Initialize dataset binding and register as dataset observer
	if(obj.selectNode.getAttribute("tmt:binding")){
		var dsName = obj.selectNode.getAttribute("tmt:binding");
		var spryDs = eval(dsName);
		obj.dataset = spryDs;
		if(obj.autoLoad == true){
			spryDs.addObserver(obj);
			spryDs.loadData();
		}
		obj.textField = obj.selectNode.getAttribute("tmt:bindingtext");
		// If binding field for value is missing, use text
		obj.valueField = obj.textField;
		if(obj.selectNode.getAttribute("tmt:bindingvalue")){
			obj.valueField = obj.selectNode.getAttribute("tmt:bindingvalue");
		}
	}
	obj.setDefaultSelected();
	return obj;
}

// Global object storing utility methods
tmt.spry.linkedselect.util = {};

/**
* Add an option to a given linkedselect
*/
tmt.spry.linkedselect.util.addOption = function(selectId, text, value){
	tmt.spry.linkedselect.util.getObjFromId(selectId).addOption(text, value);
}

/**
* Copy currently selected options from a given linkedselect to another
*/
tmt.spry.linkedselect.util.copyOptions = function(sourceId, destinationId){
	var destinationObj = tmt.spry.linkedselect.util.getObjFromId(destinationId);
	var selectedOptions = tmt.spry.linkedselect.util.getObjFromId(sourceId).getSelectedOptions();
	for(i=0; i<selectedOptions.length; i++){
		destinationObj.addOption(selectedOptions[i].text, selectedOptions[i].value);
	}
}

/**
* Private method. Given a <select> id or node, return its linkedselect object
*/ 
tmt.spry.linkedselect.util.getObjFromId = function(selectId){
	var targetNode = tmt.get(selectId);
	if(!targetNode){
		alert("Error: unable to find element " + selectId);
		return null;
	}
	var targetObj = targetNode.tmtSpryLinkedSelect;
	if(!targetObj){
		alert("Error: element " + selectId + " is not a linkedselect object. Verify it contains the tmt:linkedselect attribute");
		return null;
	}
	return targetObj;
}

/**
* Move currently selected options from a given linkedselect to another
*/
tmt.spry.linkedselect.util.moveOptions = function(sourceId, destinationId){
	tmt.spry.linkedselect.util.copyOptions(sourceId, destinationId);
	tmt.spry.linkedselect.util.getObjFromId(sourceId).deleteOptions();
}

/**
* Move currently selected options down by a position
*/
tmt.spry.linkedselect.util.moveOptionDown = function(selectId){
	tmt.spry.linkedselect.util.getObjFromId(selectId).optionsDown();
}

/**
* Move currently selected options up by a position
*/
tmt.spry.linkedselect.util.moveOptionUp = function(selectId){
	tmt.spry.linkedselect.util.getObjFromId(selectId).optionsUp();
}

/**
* Remove currently selected options
*/ 
tmt.spry.linkedselect.util.removeOption = function(selectId){
	tmt.spry.linkedselect.util.getObjFromId(selectId).deleteOptions();
}

/**
* Reset a sprylinkedselect loading only its hardcoded options
*/ 
tmt.spry.linkedselect.util.resetSelect = function(selectId){
	tmt.spry.linkedselect.util.getObjFromId(selectId).resetDefault();
}

/**
* Point a linkedselect to a new dataset for binding
*/
tmt.spry.linkedselect.util.setBinding = function(selectId, dsName){
	var dynObj = tmt.spry.linkedselect.util.getObjFromId(selectId);
	newDataset = eval(dsName);
	if(newDataset){	
		dynObj.setBinding(newDataset);
	}
	else{
		alert("Error: unable to find " + newDataset + " Spry dataset");
	}
}

/**
* Sort the options of a given linkedselect based on their text
*/ 
tmt.spry.linkedselect.util.sortSelect = function(selectId){
	tmt.spry.linkedselect.util.getObjFromId(selectId).sortOptions();
}

tmt.addEvent(window, "load", tmt.spry.linkedselect.init);