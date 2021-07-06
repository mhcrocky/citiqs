class Floorplan {


	constructor(params) {
		this.canvasJSON = '';
		this.width = 0;
		this.height = 0;
		this.imageUploaded = false;
		this.floorplanID = null;
		this.floor_name = '';
		this.drawning_mode = false;
		this.ratio = 0;
		this.pos_start = {x: 0, y: 0};
		this.pos_end = {x: 0, y: 0};
		this.img_src = '';
		this.floorElementID = '';
		this.areaClickCallback = null;
		this.deleteAreas = [];
		this.objectsImages = null;
		this.canvasOriginalWidth = 800;
		this.canvasOriginalHeight = 600;
		this.canvasWidth = 800;
		this.canvasHeight = 600;
		this.bgImage = null;
		this.scaleFactor = 1;
		this.imgEl = null;
		this.canvasScale = 1;


		for (var key in params) {
			this[key] = params[key];
		}
		this.canvas = new fabric.Canvas(this.floorElementID);

		var _this = this;
		if (this.canvasJSON) {
			this.canvas.loadFromJSON(this.canvasJSON, function () {

				_this.bgImage = _this.canvas.backgroundImage;
				_this.canvasOriginalWidth = _this.bgImage.width;
				_this.canvasOriginalHeight = _this.bgImage.height;
				_this.afterLoad();
				_this.scaleAndPositionCanvas();
			});
		} else {
			this.setCanvasEvents();
		}
	}

	setCanvasZoom(canvasScale) {
		this.canvasWidth = this.canvasOriginalWidth * canvasScale;
		this.canvasHeight = this.canvasOriginalHeight * canvasScale;

		this.canvas.setWidth(this.canvasWidth);
		this.canvas.setHeight(this.canvasHeight);
	}

	scaleAndPositionCanvas(scaleRatio = null) {
		if (!this.bgImage) return false;

		// var elWidth = this.imgEl.width();
		// var elHeight = this.imgEl.innerHeight();
		var elWidth = 800; //this.imgEl.width();
		var elHeight = 600; //this.imgEl.innerHeight();
		var canvasScale = elWidth / this.canvasOriginalWidth <= elHeight / this.canvasOriginalHeight ? elWidth / this.canvasOriginalWidth : elHeight / this.canvasOriginalHeight;
		// if (scaleRatio) {
		// 	var scaleFactor = this.scaleFactor * scaleRatio;
		// 	ratio = this.scaleFactor;
		// } else {
		//
		// }
		if (scaleRatio) {
			this.canvasScale = this.canvasScale  * scaleRatio;
		} else {
			this.canvasScale = canvasScale;
		}


		this.setCanvasZoom(this.canvasScale);

		var canvasAspect = this.canvasWidth / this.canvasHeight;
		var imgAspect = this.canvasOriginalWidth / this.canvasOriginalHeight;
		var left, top;

		if (canvasAspect >= imgAspect) {
			var scaleFactor = this.canvasWidth / this.canvasOriginalWidth;
			left = 0;
			top = -((this.canvasOriginalHeight * scaleFactor) - this.canvasHeight) / 2;
		} else {
			var scaleFactor = this.canvasHeight / this.canvasOriginalHeight;
			top = 0;
			left = -((this.canvasOriginalWidth * scaleFactor) - this.canvasWidth) / 2;

		}
		if (scaleRatio) {
			scaleFactor = this.scaleFactor * scaleRatio;
		}

		this.canvas.setBackgroundImage(this.bgImage, this.canvas.renderAll.bind(this.canvas), {
			top: top,
			left: left,
			originX: 'left',
			originY: 'top',
			scaleX: scaleFactor,
			scaleY: scaleFactor
		});
		this.scaleFactor = scaleFactor;

		this.zoomAreas(scaleFactor);
	}

	zoomAreas (scaleFactor) {
		var objects = this.canvas.getObjects();
		for (var i in objects) {
			var scaleX = objects[i].scaleX;
			var scaleY = objects[i].scaleY;
			var left = objects[i].left;
			var top = objects[i].top;
			objects[i].scaleX = scaleFactor;
			objects[i].scaleY = scaleFactor;
			objects[i].left = (left / scaleX) * scaleFactor;
			objects[i].top = (top / scaleY) * scaleFactor;

			objects[i].setCoords();
		}
		 this.canvas.renderAll();
		 this.canvas.calcOffset();
	}

	changeAreaColor (area, status) {
		var areaObject;
		if (typeof area == 'object') {
			areaObject = area;
		} else {
			this.canvas.getObjects().forEach(function (object) {
				if (typeof object.id != 'undefined' && object.id == area) {
					areaObject = object;
				}
			})
		}
		if (areaObject.get('type') == 'image') {
			return false;
		}
		areaObject.options.status = status;
		var color = areaObject.options[status + '_color'];
		var colorStr = color.replace('rgba','').replace('rgb','');
		var colorArr = colorStr.substring(1, colorStr.length-1)
			.replace(/ /g, '')
			.split(',');
		var rgbaColor = 'rgba('+colorArr[0]+','+colorArr[1]+','+colorArr[2]+',' + areaObject.options.opacity + ')';
		areaObject.set('fill', rgbaColor);
		areaObject.set('stroke', color);
		this.canvas.renderAll();
	}

	setCanvasEvents () {}

	getUniqueAreaId () {
		var unique_id = 1;
		this.canvas.getObjects().forEach(function (object, index) {
			if (object.get('type') != 'text') {
				unique_id = unique_id <= object.area_id ? object.area_id + 1 : unique_id;
			}
		})
		return unique_id;
	}

	afterLoad () {
		this.canvas.renderAll()
		var _this = this;
		setTimeout(function () {
			var objects = _this.canvas.getObjects();
			objects.forEach(function (object, index) {

				if (object.get('type') != 'text' ) {
					var label = null;
					_this.areas.forEach(function (area) {
						if (object.area_id == area.area_id) {
							if (area.area_status) {
								_this.changeAreaColor(object, area.area_status)
							}
							object.id = area.id;
							object.available = area.available;
							object.area_count = area.area_count;
							object.timeSlots = area.timeslots;
						}
					})
					objects.some(function (obj_search) {
						if (obj_search.get('type') == 'text' && obj_search.label_id == 'label_' + object.area_id) {
							label = obj_search;
							return obj_search;
						}
					});

					if (label) {
						object.label = label;
						object.label.selectable = false;
						_this.addAreaEvents(object, object.label)
					}
					object.selectable = false;
				}
			});
			_this.setCanvasEvents();
		}, 100);
	}

}
