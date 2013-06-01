$(function () {

	$('.id').bind('change keyup', function() {
		$('#'+$(this).attr('data-section')+' .url').val('/'+$(this).attr('data-url')+'/'+$(this).val());
	});

	$('.latitude_point, .longitude_point, .distance_point').bind('change keyup', function() {
		$('#get_near_points .url').val('/point/'
										+parseFloat($('.latitude_point').val())
										+'x'
										+parseFloat($('.longitude_point').val())
										+'/'
										+parseInt($('.distance_point').val())
									);
	});


    $('.nav-tabs a:first').tab('show');
    $('.nav-tabs a').click(function (e) {
		e.preventDefault();
		$(this).tab('show');
	});

    $('.clear_result').click(function(){

		$('.progress').hide();
		$('#status').html('');
		$('#response').html('');
    });

	$('.send').click(function(){
		
		var id = $(this).attr('data-section'),
			data = {};

		$('.progress').show();
		$('#status, #response').html('');

		$("#"+id+" .param").each(function() {
			if ($(this).attr('type')!='checkbox' || ($(this).attr('type') =='checkbox' && $(this).attr("checked")) ){
				data[$(this).attr('name')] = $(this).val();
			}
		});

		//console.log(data);

		$.ajax({

			type: $('#'+id+' .method').val(),
			url: '/app_dev.php'+$('#'+id+' .url').val(),
			data:data

		}).done(function( a,b,c) {

			console.log( "done: ",a, b,c);
			$('.progress').hide();
			$('#status').html(c.status);
			$('#response').html(c.responseText);

		}).error(function(a,b,c){

			console.log( "error: ", a, b,c);
			$('.progress').hide();
			$('#status').html(a.status);
			$('#response').html(a.responseText);

		});
    });
});

// универсальные табы для всех сущностей
var tabs = new Backbone.Collection([
      {title:"GET LIST",	name: "get_list",	active: 1},
      {title:"SHOW ONE",	name: "show_one",	active: 0},
      {title:"CREATE",		name: "create",		active: 0},
      {title:"UPDATE",		name: "update",		active: 0},
      {title:"DELETE",		name: "delete",		active: 0}
    ]),
    groups = new Backbone.Collection();

groups.comparator = function(group) {
    return group.get("sort");
};

var ControlGroupView = Backbone.View.extend({
	className: 'control-group',
	tagName: 'div',
	events:{
		'change .id':'change_url',
		'keyup .id':'change_url',
        'click .send':'send'
	},
	template_text: _.template('<label class="control-label"><%= title %><% print((required)?"*":""); %>:</label>'+
							'<div class="controls">'+
								'<textarea name="<%= entity %>[<%= param_name %>]" class="param"><%= value %></textarea>'+
								'<span class="help-inline"><%= entity %>[<%= param_name %>]</span>'+
							'</div>'),

	template_string: _.template('<label class="control-label"><%= title %><% print((required)?"*":""); %>:</label>'+
				'<div class="controls">'+
					'<input type="text" value="<%= value %>" name="<%= entity %>[<%= param_name %>]" class="param" <% print((required)?"required":""); %> <% print((disabled)?"disabled":""); %> />'+ 
					'<span class="help-inline"><%= entity %>[<%= param_name %>]</span>'+
				'</div>'),

	template_time: _.template('<label class="control-label"><%= title %><% print((required)?"*":""); %>:</label>'+
				'<div class="controls">'+
					'<input type="text" value="00" name="<%= entity %>[<%= param_name %>][hour]" class="time hour input-mini param" />:'+
					'<input type="text" value="00" name="<%= entity %>[<%= param_name %>][minute]" class="time minute input-mini param" />'+
					'<span class="help-inline"><%= entity %>[<%= param_name %>]</span>'+
				'</div>'),

	template_checkbox: _.template(	'<label class="control-label"><%= title %>*:</label>'+
							'<div class="controls">'+
								'<label class="checkbox inline my_width">'+
								'<input type="checkbox" name="<%= entity %>[<%= param_name %>]" class="param" value="1" checked>'+
								'да/нет'+
								'<span class="help-inline"><%= entity %>[<%= param_name %>]</span>'+
							'</div>'),

	template_submit: _.template(	'<div class="controls">'+
										'<span class="btn send" data-section="<%= param_name %>_<%= entity %>">Выполнить</span>'+
									'</div>'),

	initialize:function(){
		this.render();
	},
	render:function(){
		var content = this['template_'+this.model.get('type')](this.model.toJSON());
		this.$el.html(content);
		if (this.model.get('param_name') == 'id'){
			$('.param', this.$el).addClass('id').removeClass('param');
		}
		if (this.model.get('param_name') == 'url'){
			if (this.model.get('url')){
				$('.param', this.$el).val(this.model.get('url'));
			}
			$('.param', this.$el).addClass('url').removeClass('param');
		}
		if (this.model.get('param_name') == 'method'){
			$('.param', this.$el).addClass('method').removeClass('param');
		}
		return this;
	},
	change_url:function(){
		
		$('#'+this.model.get('name')+'_'+this.model.get('entity')+' .url').val('/'+this.model.get('entity')+'/'+$('.id', this.$el).val());
	},
    send:function(){

        var id = this.model.get('name')+'_'+this.model.get('entity'), //$(this).attr('data-section'),
            data = {};

        console.log(id);

        $('.progress').show();
        $('#status, #response').html('');

        if (this.model.get('name') != 'delete') {
	        $("#"+id+" .param").each(function() {
                if ($(this).hasClass('time')){

                    if ($(this).hasClass('hour')){
                        data[$(this).attr('name')] = parseInt($(this).val());
                    }
                    if ($(this).hasClass('minute')){
                        data[$(this).attr('name')] = parseInt($(this).val());
                    }

                } else {

                    if ($(this).attr('type')!='checkbox' || ($(this).attr('type') =='checkbox' && $(this).attr("checked")) ){
                        data[$(this).attr('name')] = $(this).val();
                    }

                }
	        });
	    }

        $.ajax({

            type: $('#'+id+' .method').val(),
            url: '/app_dev.php'+$('#'+id+' .url').val(),
            data:data

        }).done(function( a,b,c) {

                console.log( "done: ",a, b,c);
                $('.progress').hide();
                $('#status').html(c.status);
                $('#response').html(c.responseText);

        }).error(function(a,b,c){

            console.log( "error: ", a, b,c);
            $('.progress').hide();
            $('#status').html(a.status);
            $('#response').html(a.responseText);

        });
    }
});

var ControlGroupModel = Backbone.Model.extend({
	defaults: {
		title:'',
		value:'',
		param_name:'',
		required:false,
		disabled:false,
		description:"Описание"
	},
	initialize:function(){
		this.view = new ControlGroupView({model:this});
	}
});


var TabView = Backbone.View.extend({
	tagName: 'li',
	events:{
		'click':'show'
	},
	show:function(e){
		e.preventDefault();
		//console.log(this.$el.tab('show'));
		$('a', this.$el).tab('show');
	},
	initialize:function(){
		this.render();
	},
	render:function(){
		this.$el.html('<a href="#'+this.model.get('name')+'_'+this.options.entity_name+'">'+this.model.get('title')+'</a>')
		if(this.model.get('active')){
			this.$el.addClass('active');
		}
		return this;
	}
});
var TabPane = Backbone.View.extend({
	className: 'tab-pane',
	initialize:function(){
		this.render();
	},
	render:function(){

		var THIS = this;

		this.$el.html('<form class="form-horizontal">'+'</form>'); //this.model.get('name')+' - '+this.options.entity_name
		
		this.$el.attr('id',this.model.get('name')+'_'+this.options.entity_name);
		
		if(this.model.get('active')){
			this.$el.addClass('active');
		}

		groups.reset([	new ControlGroupModel({
							type:'submit',
							name:this.model.get('name'),
							entity: this.options.entity_name,
							sort:99
						})
					]);


		if (this[this.model.get('name')]){
			this[this.model.get('name')]();    // this.get_list(); || this.show_one();
		}

        if (this.model.get('name') == 'get_list'){
            console.log(groups.models);
        }

		groups.each(function(control_group){
			$('form', THIS.$el).append(control_group.view.el);
		});

		return this;
	},
	get_list:function(){
		
		groups.add([	new ControlGroupModel({
							type:'string',
							value:'GET',
							disabled:true,
							title:'METHOD',
							param_name:'method',
							name:this.model.get('name'),
							entity:this.options.entity_name,
							sort:2
						}), new ControlGroupModel({
							type:'string',
							value:'/'+this.options.url+'/',
							disabled:true,
							title:'URL',
							param_name:'url',
							name:this.model.get('name'),
							entity:this.options.entity_name,
							sort:1
						})
					]);
	},
	show_one:function(){
		groups.add([	new ControlGroupModel({
							type:'string',
							value:'GET',
							disabled:true,
							title:'METHOD',
							param_name:'method',
							name:this.model.get('name'),
							entity:this.options.entity_name,
							sort:2
						}), new ControlGroupModel({
							type:'string',
							value:'1',
							title:'ID',
							param_name:'id',
							name:this.model.get('name'),
							entity:this.options.entity_name,
							sort:3
						}), new ControlGroupModel({
							type:'string',
							value:'/'+this.options.url+'/1',
							disabled:true,
							title:'URL',
							param_name:'url',
							name:this.model.get('name'),
							entity:this.options.entity_name,
							sort:1
						})
					]);
	},
	create:function(){

		groups.add([	new ControlGroupModel({
							type:'string',
							value:'POST',
							disabled:true,
							title:'METHOD',
							param_name:'method',
							name:this.model.get('name'),
							entity:this.options.entity_name,
							sort:2
						}), new ControlGroupModel({
							type:'string',
							value:'/'+this.options.url+'/',
							disabled:true,
							title:'URL',
							param_name:'url',
							name:this.model.get('name'),
							entity:this.options.entity_name,
							sort:1
						})
					]);

		if (this.options.parameters && this.options.parameters.length > 0) {
			for (var i=0; i<this.options.parameters.length; i++){
				groups.add([
					new ControlGroupModel({
						type:this.options.parameters[i]['type'],
						value:'',
						disabled:false,
						title:this.options.parameters[i]['title'],
						param_name:this.options.parameters[i]['name'],
						name:this.model.get('name'),
						entity:this.options.entity_name,
						sort:2
					})
				]);
			}
		}
	},
	update:function(){
		groups.add([	new ControlGroupModel({
							type:'string',
							value:'PUT',
							disabled:true,
							title:'METHOD',
							param_name:'method',
							name:this.model.get('name'),
							entity:this.options.entity_name,
							sort:2
						}), new ControlGroupModel({
							type:'string',
							value:'1',
							title:'ID',
							param_name:'id',
							name:this.model.get('name'),
							entity:this.options.entity_name,
							sort:98
						}), new ControlGroupModel({
							type:'string',
							value:'/'+this.options.url+'/1',
							disabled:true,
							title:'URL',
							param_name:'url',
							name:this.model.get('name'),
							entity:this.options.entity_name,
							sort:1
						})
					]);

		if (this.options.parameters && this.options.parameters.length > 0) {
			for (var i=0; i<this.options.parameters.length; i++){
				groups.add([
					new ControlGroupModel({
						type:this.options.parameters[i]['type'],
						value:'',
						disabled:false,
						title:this.options.parameters[i]['title'],
						param_name:this.options.parameters[i]['name'],
						name:this.model.get('name'),
						entity:this.options.entity_name,
						sort:2
					})
				]);
			}
		}
	},
	delete:function(){
		groups.add([	new ControlGroupModel({
							type:'string',
							value:'DELETE',
							disabled:true,
							title:'METHOD',
							param_name:'method',
							name:this.model.get('name'),
							entity:this.options.entity_name,
							sort:2
						}), new ControlGroupModel({
							type:'string',
							value:'1',
							title:'ID',
							param_name:'id',
							name:this.model.get('name'),
							entity:this.options.entity_name,
							sort:3
						}), new ControlGroupModel({
							type:'string',
							value:'/'+this.options.url+'/1',
							disabled:true,
							title:'URL',
							param_name:'url',
							name:this.model.get('name'),
							entity:this.options.entity_name,
							sort:1
						})
					]);
	}
});

var TabsView = Backbone.View.extend({
	className: 'nav nav-tabs',
	tagName: 'ul',
	initialize:function(){
		this.render();
	},
	render:function(){

		var entity_name = this.model.get('entityName').toLowerCase(),
			THIS = this,
			url = this.model.get('url');

		_.each(tabs.models, function(tab){
			var tabview = new TabView({model:tab, entity_name:entity_name});
			THIS.$el.append(tabview.el);
		});
		return this;
	}
});

var TabsContent = Backbone.View.extend({
	className: 'tab-content',
	initialize:function(){
		this.render();
	},
	render:function(){

		var entity_name = this.model.get('entityName').toLowerCase(),
			THIS = this;
		
		_.each(tabs.models, function(tab){
			var tabpane = new TabPane({
							model:tab, 
							entity_name:entity_name, 
							url:THIS.model.get('url')?THIS.model.get('url'):entity_name, 
							parameters:THIS.model.get('parameters')
						});
			
			THIS.$el.append(tabpane.el);
		});

		return this;
	}
});


var EntityView = Backbone.View.extend({
	className:'accordion-group',
	template:_.template(	'<div class="accordion-heading">'+
								'<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse<%= entityName %>">'+
								'<%= name %>'+ //<span class="label label-success">Готово</span>
								'</a>'+
							'</div>'+
							'<div id="collapse<%= entityName %>" class="accordion-body collapse">'+
								'<div class="accordion-inner"></div>'+
							'</div>'),
	initialize:function(){	
		this.render();
	},
	render:function(){

		var content = this.template(this.model.toJSON());

		this.$el.html(content);
		this.renderTabs();
		
		return this;
	},

	renderTabs:function(){
		
		var tabsview = new TabsView({model:this.model});
		var tabscontent = new TabsContent({model:this.model});

		$('.accordion-inner', this.$el)
				.html(tabsview.el)
				.append(tabscontent.el);

		//add Tabs + TabsContent
	}

});


var Entity = Backbone.Model.extend({
	defaults:{
		name:'[неуказано]',
		type:'string',
		required:0
	},
	initialize:function(){
		this.view = new EntityView({model:this});
		$('.accordion').append(this.view.el);
	}
});

var Entities = Backbone.Collection.extend({
	model:Entity,
	initialize:function(models){
		//console.log(models); models = array models
	},
	reset:function(models){
		if (models.length>0){
			for (var i=0; models.length>i; i++){
				this.add(new Entity(models[i]));
			}
		}
	}
});

var collection_entities;

$(function () {
	collection_entities = new Entities([
		{name: "Задание", entityName: "Mission",	parameters:[
													{title:'Время выполнения', name:'runtime',type:'time',required:1},
													{title:'Активность', name:'active',type:'checkbox',required:0},
													{title:'Необходима покупка', name:'needBuy',type:'checkbox',required:0},
													{title:'Баллы за задание', name:'costs',type:'string',required:1},
													{title:'Иконки', name:'icons',type:'string',required:0},
													{title:'Описание', name:'description',type:'text',required:0},
													{title:'ID типа миссии', name:'missionType',type:'string',required:1},
													{title:'ID точки', name:'point',type:'string',required:1}
												]
		},
		{name: "Выполненное задание", entityName: "MissionAccomplished",	parameters:[
													{title:'Широта',name:'latitude',type:'string',required:1},
													{title:'Долгота',name:'longitude',type:'string',required:1},
													{title:'Демографическая информация',name:'info',type:'text',required:1},
													{title:'Ссылка (имя файла) загруженных фотографий',name:'files',type:'string',required:0},
													{title:'Статус агента',name:'info',type:'string',required:1}
												], url:'complet'
		},
		{name: "Тип вопроса", entityName: "QuestionType",	parameters:[
													{title:'Название',name:'title',type:'string',required:1}
												]
		}
		/*{name: "Сеть", entityName: "Franchise1",	parameters:[
													{title:'Лого',name:'logo',type:'string',required:0},
													{title:'Бренд',name:'brand',type:'string',required:1},
													{title:'Индустрия',name:'industry',type:'string',required:1}
												]
		},
		{name: "Точки", entityName: "Point1",	parameters:[
													{title:'Название',name:'title',type:'string',required:1},
													{title:'Описание(время работы)',name:'description',type:'text',required:0},
													{title:'Активность',name:'active',type:'checkbox',required:0},
													{title:'Широта',name:'latitude',type:'string',required:1},
													{title:'Долгота',name:'longitude',type:'string',required:1},
													{title:'Сеть',name:'franchise',type:'string',required:1}
												]
		}*/
	]);
});