/**
 * \file zpwidget.js
 * Zapatec Widget library.
 * Base Widget class.
 *
 * Copyright (c) 2004-2005 by Zapatec, Inc.
 * http://www.zapatec.com
 * 1700 MLK Way, Berkeley, California,
 * 94709, U.S.A.
 * All rights reserved.
 *
 * $Id: zpwidget.js 1193 2005-12-13 22:46:41Z alex $
 */

if (typeof Zapatec == 'undefined') {
  /**
   * \internal Namespace definition.
   */
  Zapatec = {};
}

/**
 * Constructor. Base widget.
 *
 * \param objArgs [object] object properies.
 */
Zapatec.Widget = function(objArgs) {
  // User configuration
  this.config = {};
  // Initialize object
  if (arguments.length > 0) this.init(objArgs);
};

/**
 * Initializes object.
 *
 * Important: Before calling this method, define config options for the widget.
 * Initially "this.config" object should contain all config options with their
 * default values. Then values of config options will be changed with user
 * configuration in this method. Config options provided by user that were not
 * found in "this.config" object will be ignored.
 *
 * Defines following additional config options:
 *
 * "theme" [string] Theme name that will be used to display the widget.
 * Corresponding CSS file will be picked and added into the HTML document
 * automatically.
 * Case insensitive.
 * May also contain relative or absolute URL to the themes directory.
 * E.g. ../themes/default.css or http://my.web.host/themes/default.css
 *
 * "themePath" [string] Relative or absolute URL to the grid themes directory.
 * Trailing slash is required.
 * You may also include path into "theme" option instead of using "themePath"
 * option.
 *
 * "source" Depends on "sourceType" option. Possible sources:
 * 1) "html":     [object or string] HTMLElement or its id.
 * 2) "json":     [object or string] JSON object or string (http://json.org).
 * 3) "json/url": [string] URL of JSON data source.
 * 4) "xml":      [object or string] XMLDocument object or XML string.
 * 5) "xml/url":  [string] URL of XML data source.
 *
 * "sourceType" [string] Used together with "source" option to specify how
 * source should be processed. Possible source types:
 * "html", "json", "json/url", "xml", "xml/url".
 *
 * JSON format is described at http://www.json.org.
 *
 * \param objArgs [object] user configuration.
 */
Zapatec.Widget.prototype.init = function(objArgs) {
  // Add this widget to the list
  if (typeof this.id == 'undefined') {
    this.id = Zapatec.Widget.all.length;
    Zapatec.Widget.all.push(this);
  }
  // Default configuration
  this.config.theme = '';
  this.config.themePath = 'js/zpgrid/themes/';
  this.config.source = null;
  this.config.sourceType = null;
  // Get user configuration
  if (objArgs) {
    for (var strOption in objArgs) {
      // Ignore unknown options
      if (typeof this.config[strOption] != 'undefined') {
        this.config[strOption] = objArgs[strOption];
      }
    }
  }
  // Correct theme config option
  if (typeof this.config.theme == 'string' && this.config.theme != '') {
    // Remove path
    var iPos = this.config.theme.lastIndexOf('/');
    if (iPos >= 0) {
      iPos++; // Go to first char of theme name
      this.config.themePath = this.config.theme.substring(0, iPos);
      this.config.theme = this.config.theme.substring(iPos);
    }
    // Remove file extension
    var iPos = this.config.theme.lastIndexOf('.');
    if (iPos >= 0) {
      this.config.theme = this.config.theme.substring(0, iPos);
    }
    // Make lower case
    this.config.theme = this.config.theme.toLowerCase();
  } else {
    this.config.theme = '';
  }
  // Load theme
  if (this.config.theme) {
    Zapatec.Transport.loadCss({
      url: this.config.themePath + this.config.theme + '.css'
    });
  }
};

/**
 * Array to access any widget on the page by its id number.
 */
Zapatec.Widget.all = [];

/**
 * \internal Forms class name from theme name and provided prefix and suffix.
 *
 * \param objArgs [object] following object:
 * {
 *   prefix: [string, optional] prefix,
 *   suffix: [string, optional] suffix
 * }
 * E.g. if this.config.theme == 'default' and following object provided
 * {
 *   prefix: 'zpWidget',
 *   suffix: 'Container'
 * },
 * class name will be 'zpWidgetDefaultContainer'.
 *
 * \return [string] class name.
 */
Zapatec.Widget.prototype.getClassName = function(objArgs) {
  var arrClassName = [];
  if (objArgs && objArgs.prefix) {
    arrClassName.push(objArgs.prefix);
  }
  if (this.config.theme != '') {
    arrClassName.push(this.config.theme.charAt(0).toUpperCase());
    arrClassName.push(this.config.theme.substr(1));
  }
  if (objArgs && objArgs.suffix) {
    arrClassName.push(objArgs.suffix);
  }
  return arrClassName.join('');
};

/**
 * \internal Loads data from the specified source.
 */
Zapatec.Widget.prototype.loadData = function() {
  if (this.config.source != null && this.config.sourceType != null) {
    var strSourceType = this.config.sourceType.toLowerCase();
    if (strSourceType == 'html') {
      this.loadDataHtml(Zapatec.Widget.getElementById(this.config.source));
    } else if (strSourceType == 'json') {
      if (typeof this.config.source == 'object') {
        this.loadDataJson(this.config.source);
      } else {
        this.loadDataJson(Zapatec.Transport.parseJson({
          strJson: this.config.source
        }));
      }
    } else if (strSourceType == 'json/url') {
      var self = this;
      Zapatec.Transport.fetchJsonObj({
        url: this.config.source,
        onLoad: function(objResult) {
          self.loadDataJson(objResult);
        }
      });
    } else if (strSourceType == 'xml') {
      if (typeof this.config.source == 'object') {
        this.loadDataXml(this.config.source);
      } else {
        this.loadDataXml(Zapatec.Transport.parseXml({
          strXml: this.config.source
        }));
      }
    } else if (strSourceType == 'xml/url') {
      var self = this;
      Zapatec.Transport.fetchXmlDoc({
        url: this.config.source,
        onLoad: function(objResult) {
          self.loadDataXml(objResult);
        }
      });
    }
  } else {
    this.loadDataHtml(Zapatec.Widget.getElementById(this.config.source));
  }
};

/**
 * \internal Loads data from the HTML source.
 *
 * Override this in child class.
 *
 * \param objSource [object] HTMLElement object.
 */
Zapatec.Widget.prototype.loadDataHtml = function(objSource) {
};

/**
 * \internal Loads data from the JSON source.
 *
 * Override this in child class.
 *
 * \param objSource [object] JSON object.
 */
Zapatec.Widget.prototype.loadDataJson = function(objSource) {
};

/**
 * \internal Loads data from the XML source.
 *
 * Override this in child class.
 *
 * \param objSource [object] XMLDocument object.
 */
Zapatec.Widget.prototype.loadDataXml = function(objSource) {
};

/**
 * \defgroup Utility functions.
 */
//@{

/**
 * Converts element id to reference.
 *
 * \param element [string or HTMLElement] element id or reference.
 * \return [HTMLElement] reference to element.
 */
Zapatec.Widget.getElementById = function(element) {
  if (typeof element == 'string') {
    return document.getElementById(element);
  }
  return element;
};

/**
 * Returns style attribute of the specified element.
 *
 * \param element [HTMLElement] element.
 * \return [string] style attribute value.
 */
Zapatec.Widget.getStyle = function(element) {
  var style = element.getAttribute('style') || '';
  if (typeof style == 'string') {
    return style;
  }
  return style.cssText;
};

//@}
