class FloorShow extends Floorplan {
	constructor(params) {
		super(params);
	}


	addAreaEvents (rect, label) {
		var _this = this;
		// rect.on({
		// 	'moving': function (event) {
		// 		rect.transforming = true;
		// 		_this.setLabelPosition(rect, label);
		// 	},
		//
		// 	'scaling': function (event) {
		// 		rect.transforming = true;
		// 		_this.setLabelPosition(rect, label);
		// 	},
		//
		// 	'rotating': function (event) {
		// 		rect.transforming = true;
		// 		_this.setLabelPosition(rect, label);
		// 	},
		//
		// 	'mousedown:before': function (event) {
		// 		rect.selected = _this.canvas.getActiveObject() == rect;
		// 	},
		//
		// 	'mouseup': function (event) {
		// 		_this.setLabelPosition(rect, label);
		// 		if (rect.transforming
		// 			|| typeof event.transform == 'undefined'
		// 			|| event.transform == null
		// 			|| event.transform.corner == 'deleteControl'
		// 			|| !rect.selected
		// 		)
		// 		{
		// 			rect.transforming = false;
		// 			return false
		// 		}
		// 		_this.editObject(rect);
		// 	},
		//
		// });
	}

	setCanvasEvents () {
		var _this = this;
		this.canvas.on({
			'mouse:up': function (event) {
				if (event.target && event.target.get('type') != 'text') {
					if (typeof  _this.areaClickCallback == 'function') {						
						var callbackData = {
							options: event.target.options,
							id: event.target.id,
							area_id: event.target.area_id,
							available:  event.target.available,
							area_count:  event.target.area_count,
							timeSlots: event.target.timeSlots
						};
						_this.areaClickCallback(callbackData);
					}
				}
			},
			'mouse:up:before': function (event) {

			},
			'mouse:down': function (event) {

			},
		});
	}

}
