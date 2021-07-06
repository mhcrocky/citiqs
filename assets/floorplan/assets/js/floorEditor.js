var deleteIcon = "data:image/svg+xml,%3C%3Fxml version='1.0' encoding='utf-8'%3F%3E%3C!DOCTYPE svg PUBLIC '-//W3C//DTD SVG 1.1//EN' 'http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd'%3E%3Csvg version='1.1' id='Ebene_1' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' x='0px' y='0px' width='595.275px' height='595.275px' viewBox='200 215 230 470' xml:space='preserve'%3E%3Ccircle style='fill:%23F44336;' cx='299.76' cy='439.067' r='218.516'/%3E%3Cg%3E%3Crect x='267.162' y='307.978' transform='matrix(0.7071 -0.7071 0.7071 0.7071 -222.6202 340.6915)' style='fill:white;' width='65.545' height='262.18'/%3E%3Crect x='266.988' y='308.153' transform='matrix(0.7071 0.7071 -0.7071 0.7071 398.3889 -83.3116)' style='fill:white;' width='65.544' height='262.179'/%3E%3C/g%3E%3C/svg%3E";
var editIcon = "data:image/svg+xml,%3Csvg  xmlns='http://www.w3.org/2000/svg' viewBox='0 0 448 512' class='svg-inline--fa fa-pen-square fa-w-14 fa-3x'%3E%3Cpath fill='%23ffffff' d='M400 480H48c-26.5 0-48-21.5-48-48V80c0-26.5 21.5-48 48-48h352c26.5 0 48 21.5 48 48v352c0 26.5-21.5 48-48 48zM238.1 177.9L102.4 313.6l-6.3 57.1c-.8 7.6 5.6 14.1 13.3 13.3l57.1-6.3L302.2 242c2.3-2.3 2.3-6.1 0-8.5L246.7 178c-2.5-2.4-6.3-2.4-8.6-.1zM345 165.1L314.9 135c-9.4-9.4-24.6-9.4-33.9 0l-23.1 23.1c-2.3 2.3-2.3 6.1 0 8.5l55.5 55.5c2.3 2.3 6.1 2.3 8.5 0L345 199c9.3-9.3 9.3-24.5 0-33.9z' class=''%3E%3C/path%3E%3C/svg%3E";

// import floorplan from './floorplan';

class FloorEditor extends Floorplan {


	constructor(params) {
		super(params);
		this.canvas.setDimensions({
			width: this.width,
			height: this.height
		});
		this.deleteImg = document.createElement('img');
		this.editImg = document.createElement('img');
		this.buffer = null;
		this.deleteImg.src = deleteIcon;
		this.editImg.src = editIcon;

		var _this = this;
		$(document).ready(function() {
			var ctrlDown = false,
				ctrlKey = 17,
				cmdKey = 91,
				vKey = 86,
				cKey = 67;

			$(document).keydown(function(e) {
				if (e.keyCode == ctrlKey || e.keyCode == cmdKey) ctrlDown = true;
			}).keyup(function(e) {
				if (e.keyCode == ctrlKey || e.keyCode == cmdKey) ctrlDown = false;
			});

			// Document Ctrl + C/V
			$(document).keydown(function(e) {
				if (ctrlDown && (e.keyCode == cKey)) {
					_this.handleCTRL_C();
				};
				if (ctrlDown && (e.keyCode == vKey)) {
					_this.handleCTRL_V();
				};
			});
		});
	}

	async uploadFile (file) {
		let fd = new FormData();
		fd.append('image', file);

		try {
			let result = await $.ajax({
				url: globalVariables.baseUrl + 'ajax/uploadFloorPlan',
				method: 'POST',
				data: fd,
				cache: false,
				contentType: false,
				processData: false
			});
			return result;
		} catch (error) {
			console.error(error);
		}
	}

	getAreas() {
		let areas_data = [];
		let key;
		this.canvas.getObjects().forEach(function (object, index) {
			if (object.get('type') !== 'text') {
				let area_data = {
					area_id: object.area_id
				};
				if (object.id) {
					area_data.id = object.id;
				}
				for (key in object.options) {
					area_data[key] = object.options[key];
				}
				areas_data.push(area_data);
			}
		});
		return areas_data;
	}

	async saveFloor () {
		let floorplanName = this.getFloorPlanName();

		if (!floorplanName) return;

		let canvas = JSON.stringify(this.canvas.toJSON([ 'options', 'area_id', 'label_id', 'label', 'id']));
		let areas_data = this.getAreas();
		let _this = this;
		let data = {
			'floorplan' : {
				'floorplanName' : floorplanName,
				'floorplanImage' : this.img_name,
				'canvas': canvas,
			},
			'areas': areas_data,
			'deleteAreas': this.deleteAreas,
		};
		let url = globalVariables.baseUrl + 'ajax/save_floor/';
		if (_this.floorplanID) {
			url += _this.floorplanID;
		}

		try {
			return await $.ajax({
				url: url,
				method: 'POST',
				data: data,
				success: function(data) {
					console.dir(_this.floorplanID);
					var response = $.parseJSON(data);
					if (response.status === '1') {
						if (_this.floorplanID) {
							alertifyAjaxResponse(response);
							_this.floorplanID = response.floorplanID;
							_this.updateAreasData(response.areas_data);
						} else {
							redirectToNewLocation('edit_floorplan/' + response.floorplanID);
						}
					} else {
						alertifyAjaxResponse(response);
					}
				}
			});
		} catch (error) {
			console.error(error);
		}
	}

	updateAreasData ($areas_data) {
		var objects = this.canvas.getObjects();
		for (var key in $areas_data) {
			objects.forEach(function (object, index) {
				if ($areas_data[key].area_id == object.area_id) {
					object.id = $areas_data[key].id;
				}
			});
		}
	}

	setImgName(imageName) {
		this.img_name = imageName;
		return;
	}
	setImageSrc() {
		this.img_src = globalVariables.baseUrl + 'uploads/floorPlans/' + this.img_name;
		return;
	}
	handleUploadImageResponse(response) {
		let upload_data = $.parseJSON(response);

		this.setImgName(upload_data.result.file);
		this.setImageSrc();
		
		alertifyAjaxResponse(upload_data);

		if (upload_data['status'] === '0') return;

		$("<img/>")
			.attr("src", this.img_src)
			.on("load", (el) => {
				this.canvasOriginalWidth = el.target.width;
				this.canvasOriginalHeight = el.target.height;
				fabric.Image.fromURL(this.img_src, (img) => {
					img.set({
						originX: 'left',
						originY: 'top'
					});
					this.bgImage = img;
					this.scaleAndPositionCanvas();
				});
				this.canvas.setDimensions({
					width: this.canvasOriginalWidth,
					height: this.canvasOriginalHeight
				});
			});
	}

	getFloorPlanName() {
		let floorPlan = document.getElementById('floor_plan_name');
		let floorPlanName = floorPlan.value.trim();
		if (!floorPlanName) {
			alertify.error('Floorplan name is requried');
			floorPlan.style.border = '1px solid #f00';
			return null;
		} else {
			floorPlan.style.border = 'initial';
			return floorPlanName;
		}
	}

	async addImage (image) {
		let upload_data = await this.uploadFile(image);
		this.handleUploadImageResponse(upload_data);
	}

	addObjectImage (category, file) {
		var img_src = globalVariables.baseUrl + FLOOR_IMAGES_PATH + category + '/' + file;
		var _this = this;
		$("<img/>")
			.attr("src", img_src)
			.on("load", (el) => {
				var img_width = el.target.width / this.scaleFactor;
				var img_height = el.target.height / this.scaleFactor;
				var left = _this.canvas.getWidth() /2 - img_width /2;
				var top = _this.canvas.getHeight() /2 - img_height /2;
				fabric.Image.fromURL(img_src, (img) => {
					img.scale(1).set({
						left: left,
						top: top,
						width: img_width,
						height: img_height,
						scaleX: this.scaleFactor,
						scaleY: this.scaleFactor,
						area_id: _this.getUniqueAreaId(),
						originX: 'left',
						originY: 'top',
						options: {
							area_label: '',
							area_count: 1,
							label_color: 'red',
							opacity: 0.6
						},
						transforming: false
					});

					var label = this.addLabel(img);
					img.label = label;
					_this.canvas.add(img).setActiveObject(img);
					_this.addAreaEvents (img, label);
					_this.canvas.renderAll();
				});

			});
	}

	addRect () {
		var width = Math.abs(this.pos_start.x - this.pos_end.x);
		var height = Math.abs(this.pos_start.y - this.pos_end.y);
		if (width < 10 || height < 10) {
			return false;
		}

		var rect = new fabric.Rect({
			left: this.pos_start.x <= this.pos_end.x ? this.pos_start.x : this.pos_end.x,
			top: this.pos_start.y <= this.pos_end.y ? this.pos_start.y : this.pos_end.y,
			area_id: this.getUniqueAreaId(),
			fill: 'rgba(89,197,90,0.6)',
			width: width / this.scaleFactor,
			height: height / this.scaleFactor,
			scaleX: this.scaleFactor,
			scaleY: this.scaleFactor,
			hoverCursor: 'pointer',
			objectCaching: false,
			stroke: 'rgb(89,197,90)',
			strokeWidth: 4,
			options: {
				occupied_color: 'rgba(254,48,0)',
				free_color: 'rgba(89,197,90)',
				unavailable_color: 'rgba(136,139,137)',
				label_color: 'red',
				area_label: '',
				area_count: 1,
				status: 'free',
				opacity: 0.6
			},
			transforming: false
		});


		var label = this.addLabel(rect);
		rect.label = label;

		this.addAreaEvents (rect, label);
		this.canvas.add(rect);
	}

	addCircle () {
		var width = Math.abs(this.pos_start.x - this.pos_end.x) /2 ;
		var height = Math.abs(this.pos_start.y - this.pos_end.y) /2 ;
		if (width < 10 || height < 10) {
			return false;
		}

		var radius = width <= height ? width : height ;
		var circle = new fabric.Circle({
			radius: radius / this.scaleFactor,
			scaleX: this.scaleFactor,
			scaleY: this.scaleFactor,
			area_id: this.getUniqueAreaId(),
			fill: 'rgba(89,197,90,0.6)',
			top: this.pos_start.y,
			left: this.pos_start.x,
			stroke: 'rgb(89,197,90)',
			strokeWidth: 4,
			options: {
				occupied_color: 'rgba(254,48,0)',
				free_color: 'rgba(89,197,90)',
				unavailable_color: 'rgba(136,139,137)',
				label_color: 'red',
				area_label: '',
				area_count: 1,
				status: 'free',
				opacity: 0.6
			},
			transforming: false
		})

		var label = this.addLabel(circle);
		circle.label = label;

		this.addAreaEvents (circle, label);
		this.canvas.add(circle);
	}

	addLabel (area) {
		var label = new fabric.Text(area.options.area_label,
			{
				label_id:  'label_'+area.area_id,
				fill: area.options.label_color,
				left: area.left,
				top: area.top,
				selectable: false,
				fontSize: 25
			}
		);

		this.setLabelPosition(area, label);
		this.canvas.add(label);
		return label;
	}

	addAreaEvents (area, label) {
		var _this = this;
		area.on({
			'moving': function (event) {
				area.transforming = true;
				_this.setLabelPosition(area, label);
			},

			'scaling': function (event) {
				area.transforming = true;
				_this.setLabelPosition(area, label);
			},

			'rotating': function (event) {
				area.transforming = true;
				_this.setLabelPosition(area, label);
			},

			'mousedown:before': function (event) {
				area.selected = _this.canvas.getActiveObject() == area;
			},

			'mouseup': function (event) {
				_this.setLabelPosition(area, label);
				if (area.transforming
					|| typeof event.transform == 'undefined'
					|| event.transform == null
					|| event.transform.corner == 'deleteControl'
					|| !area.selected
				)
				{
					area.transforming = false;
					return false
				}
				_this.editObject(area);
			},

		});
	}

	setLabelPosition (area, label) {
		var normalRectPoint = {
			x: (area.left - area.getCenterPoint().x) * Math.cos(fabric.util.degreesToRadians(-1 * area.angle)) - (area.top - area.getCenterPoint().y) * Math.sin(fabric.util.degreesToRadians(-1 * area.angle)) + area.getCenterPoint().x,
			y: (area.left - area.getCenterPoint().x) * Math.sin(fabric.util.degreesToRadians(-1 * area.angle)) + (area.top - area.getCenterPoint().y) * Math.cos(fabric.util.degreesToRadians(-1 * area.angle)) + area.getCenterPoint().y,
		};

		var textPoint = {
			x: normalRectPoint.x + (area.getScaledWidth() - label.getScaledWidth()) / 2 - area.getCenterPoint().x,
			y: normalRectPoint.y - label.getScaledHeight() - 3 - area.getCenterPoint().y
		};

		textPoint = {
			x: textPoint.x * Math.cos(fabric.util.degreesToRadians(area.angle)) - textPoint.y * Math.sin(fabric.util.degreesToRadians(area.angle)) + area.getCenterPoint().x,
			y: textPoint.x * Math.sin(fabric.util.degreesToRadians(area.angle)) + textPoint.y * Math.cos(fabric.util.degreesToRadians(area.angle)) + area.getCenterPoint().y,
		};

		label.top = textPoint.y;
		label.left = textPoint.x;
		label.angle = area.angle;
	}

	editObject (target) {
		//set spot options
		for (var key in target.options) {
			if (key.indexOf('color') != -1) {
				$("#" + key + ' input').val(target.options[key]).trigger('change');
			} else {
				$('#' + key).val(target.options[key]);
			}
		}
		if (target.get('type') == 'image') {
			$('#area_options .area_input').hide();
			$('#area_options .image_input').show();
		} else {
			$('#area_options .area_input').show();
			$('#area_options .image_input').hide();
		}
		$('#area_options').modal();
	}

	renderIcon (icon) {
		return function renderIcon(ctx, left, top, styleOverride, fabricObject) {
			var size = this.cornerSize;
			ctx.save();
			ctx.translate(left, top);
			ctx.rotate(fabric.util.degreesToRadians(fabricObject.angle));
			ctx.drawImage(icon, -size / 2, -size / 2, size, size);
			ctx.restore();
		};
	}

	drawningModeToggle (el) {
		if (this.drawning_mode) {
			this.drawning_mode = false;
			this.canvas.getObjects().map(function(object) {
				object.selectable = false;
				return object;
			});
			this.canvas.discardActiveObject().renderAll();
			el.removeClass('btn-primary').addClass('btn-outline-primary').text('Drawning mode off');
		} else {
			this.drawning_mode = true;
			this.canvas.getObjects().map(function(object) {
				if (object.get('type') != 'text') {
					object.selectable = true;
				}
				return object;
			});
			el.removeClass('btn-outline-primary').addClass('btn-primary').text('Drawning mode on');
		}
	}

	setCanvasEvents () {
		var _this = this;
		this.canvas.on({
			'mouse:up': function (event) {
				if (!event.target) {
					_this.canvas.active_element = null;
				}

				if (event.target || !_this.drawning_mode) {
					return false;
				}
				_this.pos_end = event.pointer;
				if ($('#area_type').val() == 'rect') {
					_this.addRect();
				} else {
					_this.addCircle();
				}
				//_this.addRect();

			},
			'mouse:up:before': function (event) {
				//console.log('mouse:up:before', event);
			},
			'mouse:down': function (event) {
				//console.log('mouse:down', event);
				if (event.target || !_this.drawning_mode) {
					return false;
				}
				_this.pos_start = event.pointer;
			},
		});
	}

	deleteObject (eventData, target) {
		if (typeof target.id != 'undefined') {
			this.deleteAreas.push(target.id);
		}
		var objectCanvas = target.canvas;
		if (target.label) {
			var ObjectLabelCanvas = target.label.canvas;
			ObjectLabelCanvas.remove(target.label);
		}
		objectCanvas.remove(target);
	}

	updateLabel (object) {
		let label = object.label;
		label.set('text', object.options.area_label);
		label.set('fill', object.options.label_color);
		this.setLabelPosition(object, label);
	}

	updateArea (options) {
		let object = this.canvas.getActiveObject();

		for (var prop in object.options) {
			object.options[prop] = options[prop];
		}
		let label = object.label;
		this.updateLabel(object);
		this.changeAreaColor(object, 'free');

		label.set('fill', object.options.label_color);
		this.canvas.renderAll();
	}

	handleCTRL_C () {
		if (!this.drawning_mode)  {
			return false;
		}
		var _this = this;
		var area = this.canvas.getActiveObject();
		if (area && area.get('type') != 'text') {
			area.clone(function(cloned) {
				_this.buffer = cloned;
			}, ['area_id', 'options']);
		}
	}

	handleCTRL_V () {
		if (!this.buffer || !this.drawning_mode) {
			return false;
		}
		var _this = this;
		this.buffer.clone(function(clonedObj) {
			_this.canvas.discardActiveObject();
			clonedObj.set({
				left: clonedObj.left + 20,
				top: clonedObj.top + 20,
				evented: true,
			});
			if (clonedObj.type === 'activeSelection') {
				// active selection needs a reference to the canvas.
				clonedObj.canvas = _this.canvas;
				clonedObj.forEachObject(function(obj) {
					_this.canvas.add(obj);
				});
				// this should solve the unselectability
				clonedObj.setCoords();
			} else {
				_this.canvas.add(clonedObj);
			}

			clonedObj.area_id = _this.getUniqueAreaId();
			if (clonedObj.get('type') != 'text') {
				var label = _this.addLabel(clonedObj);
				clonedObj.label = label;
				_this.addAreaEvents(clonedObj, label);
			}
			_this.canvas.setActiveObject(clonedObj);
			_this.canvas.requestRenderAll();
		}, ['area_id', 'options']);
	}
}
