// Copyright Zikula Foundation 2010 - license GNU/LGPLv3 (or at your option, any later version).
Zikula.define("Menutree");Zikula.Menutree.Tree=Class.create(Zikula.TreeSortable,{initialize:function($super,b,a){a=this.decodeConfig(a);a=Object.extend({unactiveClass:"z-tree-unactive",dynamicClass:"z-tree-dynamic",nodeIdPrefix:"node_",dynamicPattern:function(c){return c?c.startsWith("{ext:"):false},langs:["en"],stripBaseURL:false,onSave:this.save.bind(this),saveContentTo:"menutree_content"},a||{});a.langLabels=Object.extend({delConfirm:Zikula.__("Do you really want to delete this node and all of it child nodes?"),linkname:Zikula.__("Link name"),linkhref:Zikula.__("Link URL"),linktitle:Zikula.__("Link title"),linkclass:Zikula.__("Link class"),linkclassblank:Zikula.__("Select class"),linklang:Zikula.__("Language"),linkstate:Zikula.__("Active?"),activate:Zikula.__("Activate"),deactivate:Zikula.__("Deactivate"),edit:Zikula.__("Edit"),remove:Zikula.__("Delete"),add:Zikula.__("Add new..."),before:Zikula.__("before"),after:Zikula.__("after"),bottom:Zikula.__("as child"),expand:Zikula.__("Expand this node"),collapse:Zikula.__("Collapse this node"),multitoggle:Zikula.__("Status"),multiactivate:Zikula.__("Activate for all langs"),multideactivate:Zikula.__("Deactivate for all langs"),usedefault:Zikula.__("Use one for all langs"),cancel:Zikula.__("Cancel"),submit:Zikula.__("Save"),required:Zikula.__("Please fill required fields"),forminfo:Zikula.__("Marked fields are required"),maxdepthreached:Zikula.__("Maximum depth reached. Limit is: "),warnbeforeunload:Zikula.__("You have unsaved changes!")},a.langLabels);a.images=Object.extend({edit:"menu/folder_edit.png",remove:"menu/folder_delete.png",add:"menu/folder_add.png",before:"menu/before.png",after:"menu/after.png",bottom:"menu/aschild.png",collapse:"menu/collapse.png",expand:"menu/expand.png",activate:"menu/folder_on.png",deactivate:"menu/folder_off.png",multitoggle:"menu/all-onoff.png",multiactivate:"menu/all-on.png",multideactivate:"menu/all-off.png"},a.images);this.multilingual=a.langs.length>1;this.cLang=a.langs[0];this.defaultLang=a.langs[0];$super(b,a);this.stripBaseURL();this.attachMenu();this.buildForm();this.observeForm();this.unsaved=false;Event.observe(window,"beforeunload",this.beforeUnloadHandler.bindAsEventListener(this))},initNode:function($super,a){a.select("a[lang!="+this.cLang+"]").invoke("hide");if(!a.down("."+this.config.icon)){a.insert({top:new Element("img",{className:this.config.icon})})}if((!a.down("."+this.config.toggler))){a.insert({top:new Element("img",{className:this.config.toggler,src:this.config.images.plus})})}$super(a)},insertNode:function($super,c,d,b){var a=$super(c,d,b);if(a){this.unsaved=true}return a},stripBaseURL:function(){if(this.config.stripbaseurl){var a=new RegExp("^"+Zikula.Config.baseURL);this.tree.select("a").each(function(b){b.href=b.readAttribute("href").replace(a,"")}.bind(this))}},serializeNode:function($super,b,a){return this.getNodeData(b,a,true)},observeForm:function(){this.tree.up("form").observe("submit",this.sendSaved.bindAsEventListener(this))},sendSaved:function(){this.save();this.unsaved=false},save:function(a,c,b){if(a&&c&&Object.isElement(c[1])&&c[1].hasClassName(this.config.dynamicClass)&&c[0]=="bottom"){return false}b=b||this.serialize();if(!$("menutree_content")){this.tree.up("form").insert(new Element("input",{type:"hidden",id:this.config.saveContentTo,name:this.config.saveContentTo}))}$("menutree_content").setValue(Zikula.urlsafeJsonEncode(b,false));return true},changeLang:function(a){this.tree.select("li a[lang="+this.cLang+"]").invoke("hide");this.cLang=a;this.tree.select("li a[lang="+this.cLang+"]").invoke("show")},attachMenu:function(){this.config.menuConfig=Object.extend({objs:"",trigger:"click",dynamic:true},this.config.menuConfig);this.config.menuConfig.objs="#"+this.tree.id+" li a";this.menuItemsBind=this.menuItems.bind(this);this.config.menuConfig.items=this.menuItemsBind;this.menu=new ContextMenu(this.config.menuConfig)},menuItems:function(e){var f=this.menuAction.bind(this),d=e.element(),b={};if(d.up("li").down("ul")&&d.up("li").down("ul").visible()){b={name:"collapse",displayname:this.config.langLabels.collapse,img:this.config.images.collapse,action:f}}else{if(d.up("li").down("ul")&&!d.up("li").down("ul").visible()){b={name:"expand",displayname:this.config.langLabels.expand,img:this.config.images.expand,action:f}}else{b={name:"expand",displayname:this.config.langLabels.expand,disabled:true,img:this.config.images.expand,action:f}}}if(this.config.maxDepth>0){var a=(this.countLevels(d.up("li"),"up")+2)>this.config.maxDepth}var c={edit:{name:"edit",displayname:this.config.langLabels.edit,img:this.config.images.edit,action:f},remove:{name:"remove",displayname:this.config.langLabels.remove,img:this.config.images.remove,confirm:this.config.langLabels.delConfirm,action:f},add:{name:"add",displayname:this.config.langLabels.add,img:this.config.images.add,action:{before:{name:"before",displayname:this.config.langLabels.before,img:this.config.images.before,action:f},after:{name:"after",displayname:this.config.langLabels.after,img:this.config.images.after,action:f},bottom:{name:"bottom",displayname:this.config.langLabels.bottom,img:this.config.images.bottom,action:f,disabled:a}}},s1:true,expand:b,toggle:{name:"toggle",displayname:d.hasClassName(this.config.unactiveClass)?this.config.langLabels.activate:this.config.langLabels.deactivate,img:d.hasClassName(this.config.unactiveClass)?this.config.images.activate:this.config.images.deactivate,action:f}};if(this.multilingual){Object.extend(c,{onoffs:{name:"onoffs",displayname:this.config.langLabels.multitoggle,img:this.config.images.multitoggle,action:{on:{name:"on",displayname:this.config.langLabels.multiactivate,img:this.config.images.multiactivate,action:f},off:{name:"off",displayname:this.config.langLabels.multideactivate,img:this.config.images.multideactivate,action:f}}}})}return c},menuAction:function(b,a){var c=a.element().tagName=="LI"?a.element()._name:a.element().up("li")._name,d=b.element();switch(c){case"expand":this.expandAll(d.up("li"));break;case"collapse":this.collapseAll(d.up("li"));break;case"remove":this.deleteNode(d);break;case"toggle":this.switchNode(d);break;case"on":this.switchNode(d,true,true);break;case"off":this.switchNode(d,true,false);break;case"edit":this.readNode(d);this.formaction=c;this.showForm(d);break;case"before":case"after":case"bottom":this.readNode();this.formaction=c;this.referer=d.up("li");this.showForm(d);break}},deleteNode:function(b){var a=b.up("li");Droppables.remove(a);a.select("li").each(function(c){Droppables.remove(c)}.bind(this));a.remove();this.drawNodes();this.unsaved=true},switchNode:function(c,b,a){if(b){if(a){c.up("li").select("a").invoke("removeClassName",this.config.unactiveClass)}else{c.up("li").select("a").invoke("addClassName",this.config.unactiveClass)}}else{c.toggleClassName(this.config.unactiveClass)}this.unsaved=true},getNodeData:function(d,b,f){var c,a={},e=f?"":"link_";this.config.langs.each(function(g){c=d.down("a[lang="+g+"]");a[g]={};a[g][e+"id"]=this.getNodeId(d);a[g][e+"name"]=c.innerHTML;a[g][e+"title"]=c.readAttribute("title");a[g][e+"className"]=$w(c.className).without(this.config.unactiveClass).join(" ");a[g][e+"state"]=!c.hasClassName(this.config.unactiveClass);a[g][e+"href"]=c.readAttribute("href");a[g][e+"lang"]=c.readAttribute("lang");a[g][e+"lineno"]=b||null;a[g][e+"parent"]=d.up("#"+this.tree.id+" li")?this.getNodeId(d.up("#"+this.tree.id+" li")):0}.bind(this));return a},setNodeData:function(b,c){var a;this.config.langs.each(function(d){if(c[d]){a=b.down("a[lang="+d+"]");a.update(c[d].link_name.escapeHTML()||"");a.writeAttribute("href",c[d].link_href||null);a.writeAttribute("title",c[d].link_title?c[d].link_title.escapeHTML():null);a.writeAttribute("className",c[d].link_className||null);if(!c[d].link_state){a.addClassName(this.config.unactiveClass)}a.writeAttribute("lang",c[d].link_lang||this.defaultLang);this.unsaved=true}}.bind(this));if(b.select("a").any(function(d){return this.config.dynamicPattern(d.readAttribute("href"))}.bind(this))){b.addClassName(this.config.dynamicClass)}this.save();this.tree.fire("tree:item:save",{node:b})},addNode:function(){var b=new Element("li",{id:this.config.nodeIdPrefix+this.genNextId()});switch(this.formaction){case"new":this.tree.insert(b);break;case"before":this.referer.insert({before:b});break;case"after":this.referer.insert({after:b});break;case"bottom":var a=this.referer.down("ul");if(a){a.insert({bottom:b});a.show()}else{this.referer.insert(new Element("ul").insert(b))}break}this.config.langs.each(function(e){var d=new Element("a",{lang:e});b.insert(d);if(!this.tmp[e]||!this.tmp[e].link_name){var c=this.config.langs.find(function(f){return this.tmp[f].link_name}.bind(this));this.tmp[e].link_name=this.tmp[c].link_name;this.tmp[e].link_state=false}}.bind(this));this.setNodeData(b,this.tmp);b.select("a").each(this.menu.add.bind(this.menu));this.initNode(b);this.drawNodes()},readNode:function(c){this.tmp={};if(c&&Object.isElement(c)){c=c.tagName=="LI"?c:c.up("li");this.tmp=this.getNodeData(c);var b=[];var a=[];this.config.langs.each(function(d){b.push(this.tmp[d].link_href);a.push(this.tmp[d].link_className)}.bind(this));this.tmp.global={link_href:b.uniq().size()<=1,link_className:a.uniq().size()<=1}}else{this.config.langs.each(function(d){this.tmp[d]=Object.extend({link_state:true,link_lang:d},c||{})}.bind(this));this.tmp.global={link_href:true,link_className:true}}},newNode:function(b){if(b){for(var a in b){b[a]=b[a].unescapeHTML()}}this.readNode(b);this.formaction="new";this.showForm()},buildForm:function(){if(!this.formDialog){this.formDialog=new Zikula.UI.FormDialog($("menutree_form_container"),this.submitForm.bind(this),{title:$("menutree_form_container").title});this.form=this.formDialog.window.container.down("form");if($("link_lang")){$("link_lang").observe("change",this.changeFormLang.bindAsEventListener(this))}}},loadFormValues:function(d,a){d=d?d:this.cLang;this.formLang=d;var c=this.tmp[d],b=this.tmp.global;if(a&&this.tmp.global.link_href){c.href=this.tmp[a].link_href}if(a&&this.tmp.global.link_className){c.link_className=this.tmp[a].link_className}this.form.getElements().each(function(e){if(e.id.startsWith("global_")){e.setValue(b[e.id.replace("global_","")])}else{e.setValue(c[e.id])}})},showForm:function(a){this.buildForm();this.form.reset();this.formLang=this.cLang;if($("requiredInfo")){$("requiredInfo").hide()}this.editedNode=Object.isElement(a)?a.up("li").id:this.genNextId();this.loadFormValues();this.formDialog.open()},submitForm:function(a){if(!a){delete this.tmp;return}delete a.submit;this.tmp[this.formLang]=a;if(this.tmp.global&&(this.tmp.global.link_href||this.tmp.global.link_className)){this.config.langs.each(function(b){if(this.tmp.global.link_href){this.tmp[b].link_href=a.link_href}if(this.tmp.global.link_className){this.tmp[b].link_className=a.link_className}}.bind(this))}if(this.formaction=="edit"){this.setNodeData($(this.editedNode),this.tmp)}else{this.addNode()}},changeFormLang:function(a){var c=a.element().value,b=this.form.serialize(true);b.link_lang=this.formLang;this.tmp[this.formLang]=b;this.tmp.global.link_href=b.global_link_href;this.tmp.global.link_className=b.global_link_className;this.loadFormValues(c,this.formLang)},genNextId:function(){var a=this.tree.select("li").max(function(b){return parseInt(this.getNodeId(b))}.bind(this));a=isNaN(a)?0:a;return ++a},beforeUnloadHandler:function(a){if(this.unsaved&&this.config.langLabels.warnbeforeunload){return a.returnValue=this.config.langLabels.warnbeforeunload}return false}});Object.extend(Zikula.Menutree.Tree,{add:function(b,a){if(!this.inst){this.inst=new Zikula.Menutree.Tree(b,a)}}});Element.addMethods({appendText:function(a,b){a.appendChild(document.createTextNode(b));return $(a)}});