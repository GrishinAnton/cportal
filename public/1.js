webpackJsonp([1],{

/***/ "./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"],\"uglify\":true}}]],\"plugins\":[\"transform-object-rest-spread\",[\"transform-runtime\",{\"polyfill\":false,\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./resources/assets/js/components/Salary.vue":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//

/* harmony default export */ __webpack_exports__["default"] = ({
    props: {
        personalId: {
            type: Number,
            required: true
        },

        date: {
            type: String,
            required: true
        },
        penaltyTime: {
            type: String
        }
    },
    data: function data() {
        return {
            changeData: {
                fixSalary: '',
                coef: '',
                salaryHour: 0,
                closeHours: 0,
                penaltyTime: 0,
                salary: 0
            },
            staticData: {
                salaryHour: 0,
                closeHours: 0,
                penaltyTime: 0,
                salary: 0
            },
            postData: {
                salaryId: ''
            }
        };
    },
    methods: {
        onChangeSalaryHour: function onChangeSalaryHour(e) {
            this.staticData.salary = e.target.value * ((this.changeData.closeHours || this.staticData.closeHours) - (this.changeData.penaltyTime || this.staticData.penaltyTime));
        },
        onChangeSalary: function onChangeSalary(e) {
            this.staticData.salary = e.target.value;

            this.staticData.salaryHour = e.target.value / (this.changeData.closeHours || this.staticData.closeHours);
        },
        saveSalary: function saveSalary() {
            var day = new Date();

            axios.post('/api/personal/' + this.personalId + '/salary/store/' + this.postData.salaryId, {
                salaryFix: this.changeData.salaryHour || this.staticData.salaryHour,
                salary: this.changeData.salary || this.staticData.salary,
                coef: this.changeData.coef,
                hour: this.changeData.salaryHour || this.staticData.salaryHour,
                date: this.date + '-' + day.getDay(),
                editHours: this.changeData.salaryHour || this.staticData.salaryHour,
                editSalary: this.changeData.closeHours || this.staticData.closeHours
            }).then(function (response) {
                console.log(response);
            }).catch(function (e) {
                console.log(e);
            });
        }
    },
    created: function created() {
        var _this = this;

        this.staticData.penaltyTime = this.penaltyTime ? this.penaltyTime : 0;

        axios.get('/api/personal/' + this.personalId + '?date=' + this.date).then(function (response) {

            var data = response.data;

            //отправляем данные в store чтобы загрузить группы
            _this.$store.commit('personal/personalInformation', data);

            console.log(data);

            _this.changeData.coef = data.salary ? data.salary.coefficient : 0;
            _this.staticData.closeHours = data.first ? Math.trunc(_.sumBy(data.first.times, 'totaltime')) : '';
            _this.staticData.salary = data.salary ? data.salary.salary.toFixed(2) : '';
            _this.staticData.salaryHour = data.salary ? data.salary.edit_hours.toFixed(2) : '';

            _this.postData.salaryId = data.salary ? data.salary.id : '';
        }).catch(function (e) {
            console.log(e);
        });
    }
});

/***/ }),

/***/ "./node_modules/css-loader/index.js!./node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-38626701\",\"scoped\":false,\"hasInlineConfig\":true}!./node_modules/vue-loader/lib/selector.js?type=styles&index=0!./resources/assets/js/components/Salary.vue":
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__("./node_modules/css-loader/lib/css-base.js")(false);
// imports


// module
exports.push([module.i, "\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\r\n/*\r\n    // export default {\r\n    //     props: {\r\n    //         personalId: {\r\n    //             type: Number,\r\n    //             required: true\r\n    //         },\r\n    //         date: {\r\n    //             type: String,\r\n    //             required: true\r\n    //         }\r\n    //     },\r\n    //     data() {\r\n    //         return {\r\n    //             post: {\r\n    //                 validSalary: null,\r\n    //                 costs: false\r\n    //             },\r\n\r\n    //             form: {\r\n    //                 fix: null,\r\n    //                 closeHours: null,\r\n    //                 addHours: null,\r\n    //                 estimatedTime: null,\r\n    //                 salary: null,\r\n    //                 posts: null,\r\n    //                 coef: 1.1,\r\n    //                 salaryHours: null,\r\n    //                 editSalary: null,\r\n    //                 costs: null,\r\n    //                 editCosts: []\r\n    //             },\r\n\r\n    //             get: {\r\n    //                 info: null,\r\n    //                 salary: null,\r\n    //                 trackedTime: null,\r\n    //                 times: null,\r\n    //                 fullEstimatedTime: 0,\r\n    //                 timeRecords: null,\r\n    //                 costs: null,\r\n    //             }\r\n    //         }\r\n    //     },\r\n    //     created() {\r\n    //         axios.get('/api/personal/'+this.personalId+'?date='+this.date)\r\n    //             .then(response => {\r\n                \r\n    //                 this.get.info = response.data.first;\r\n    //                 this.get.salary = response.data.salary;\r\n    //                 this.get.trackedTime = _.sumBy(this.get.info.times, 'totaltime').toFixed(2);\r\n    //                 this.get.times = this.get.info.times;\r\n    //                 this.get.timeRecords = response.data.timeRecords;\r\n    //                 this.get.costs = response.data.costs.cost;\r\n    //                 this.post.costs = response.data.projectCosts; \r\n\r\n    //                 this.$store.commit('personal/personalInformation', response.data)\r\n\r\n    //                 if (this.get.salary !== null) {\r\n    //                     this.validSalary = '/'+this.get.salary.id;\r\n    //                 } else {\r\n    //                     this.validSalary = '';\r\n    //                 }\r\n\r\n    //                 if (this.get.salary !== null) {\r\n    //                     this.form.salaryHours = this.get.salary.hour;\r\n    //                     this.form.fix = this.get.salary.salary_fix;\r\n    //                     this.form.coef = this.get.salary.coefficient;\r\n    //                     this.form.salary = this.get.salary.salary;\r\n    //                     this.form.addHours = this.get.salary.edit_hours;\r\n    //                     this.form.editSalary = this.get.salary.edit_salary;\r\n    //                 }\r\n                  \r\n                     \r\n    //             })\r\n    //             .catch(e => {\r\n    //                 console.log(e);\r\n    //             })\r\n    //     },\r\n    //     methods: {\r\n    //         costs : function () {               \r\n    //             for (var timeRecord in this.get.timeRecords) {\r\n    //                 if (this.get.timeRecords[timeRecord]['worktime'] !== null) {\r\n    //                     if (this.get.timeRecords[timeRecord]['project_id'] in this.form.editCosts) {\r\n    //                         var projectCost = this.form.editCosts[this.get.timeRecords[timeRecord]['project_id']];\r\n    //                     } else {\r\n    //                         if (_.get(this.get.salary, 'edit_salary') && this.get.salary.edit_salary !== '0.00') {\r\n    //                             var projectCost = ((this.get.salary.edit_salary * parseFloat(this.get.timeRecords[timeRecord]['worktime']/this.get.trackedTime)) + (this.get.costs * parseFloat(this.get.timeRecords[timeRecord]['worktime']/this.get.trackedTime))).toFixed(2);\r\n    //                         } else {\r\n    //                             var projectCost = ((this.salary * parseFloat(this.get.timeRecords[timeRecord]['worktime']/this.get.trackedTime)) + (this.get.costs * parseFloat(this.get.timeRecords[timeRecord]['worktime']/this.get.trackedTime))).toFixed(2);\r\n    //                         }\r\n    //                     }\r\n                        \r\n    //                     axios.post('/api/personal/'+this.personalId+'/costs/store', {\r\n    //                         projectId: this.get.timeRecords[timeRecord]['project_id'],\r\n    //                         projectCost: projectCost,\r\n    //                         date: this.date,\r\n    //                         workTime: this.get.timeRecords[timeRecord]['worktime']\r\n    //                     })\r\n    //                     .then(response => {\r\n    //                         this.post.costs = true;\r\n    //                         //return console.log(response);\r\n    //                     })\r\n    //                     .catch(function (error) {\r\n    //                         return console.log(error);\r\n    //                     });\r\n    //                 }\r\n    //             }\r\n    //         },\r\n    //         postSalary: function () {\r\n    //             var day = new Date();\r\n               \r\n\r\n    //             axios.post('/api/personal/'+this.personalId+'/salary/store'+this.validSalary, {\r\n    //                 salaryFix: this.isSalaryFixed,\r\n    //                 salary: this.salary,\r\n    //                 coef: this.form.coef,\r\n    //                 hour: this.valueHours,\r\n    //                 date: this.date+'-'+day.getDay(),\r\n    //                 editHours: this.form.addHours ,\r\n    //                 editSalary: this.form.editSalary\r\n    //             })\r\n    //             .then(response => {\r\n    //                 this.get.salary = response.data;\r\n\r\n    //                 if (this.get.salary !== null) {\r\n    //                     this.validSalary = '/'+this.get.salary.id;\r\n    //                 } else {\r\n    //                     this.validSalary = '';\r\n    //                 }\r\n\r\n    //                     this.form.salaryHours = this.get.salary.hour;\r\n    //                     this.form.fix = this.get.salary.salary_fix;\r\n    //                     this.form.coef = this.get.salary.coefficient;\r\n    //                     this.form.salary = this.get.salary.salary;\r\n    //                     this.form.addHours = this.get.salary.edit_hours;\r\n    //                     this.form.editSalary = this.get.salary.edit_salary;\r\n    //             })\r\n    //             .catch(function (error) {\r\n    //                 return console.log(error);\r\n    //             });\r\n    //         }\r\n    //     },\r\n    //     computed: {\r\n    //         isSalaryFixed() {\r\n    //             return this.form.fix;\r\n    //         },\r\n    //         fineHours() {               \r\n    //             for (var task in this.get.times) {                                 \r\n    //                 this.get.fullEstimatedTime += parseFloat(this.get.times[task].tasks.estimated_time);\r\n    //             }\r\n    //         },\r\n    //         salary() {\r\n    //             if (Number(this.form.fix) === 0) { \r\n                        \r\n    //                 if (isNaN(parseFloat(this.form.addHours))) {\r\n                        \r\n    //                     return (this.closeHours - this.fineHours) * this.form.salaryHours;\r\n\r\n    //                 } else {\r\n\r\n    //                     return ((parseFloat(this.closeHours) + parseFloat(this.form.addHours)) - this.fineHours) * this.form.salaryHours;\r\n    //                 }\r\n\r\n    //             } else {\r\n    //                 return this.form.salary;\r\n    //             } \r\n    //         },\r\n    //         closeHours() {\r\n    //                 console.log(this.get.trackedTime)\r\n    //                 return this.get.trackedTime;\r\n                \r\n    //         },\r\n    //         valueHours() {\r\n    //             if (this.form.fix !== 0) {\r\n    //                 return this.salary / (this.get.trackedTime - this.fineHours);\r\n    //             }\r\n\r\n    //             return this.form.salaryHours;\r\n\r\n    //         },\r\n    //         valueHoursWithoutFine() {\r\n    //             if (isNaN(parseFloat(this.form.addHours))) {     \r\n    //                 return parseFloat(this.closeHours) * parseFloat(this.form.salaryHours);\r\n    //             } \r\n\r\n    //             return parseFloat(this.closeHours + this.form.addHours) * parseFloat(this.form.salaryHours);\r\n                \r\n    //         }\r\n    //     }\r\n    // }\r\n    \r\n*/\r\n", ""]);

// exports


/***/ }),

/***/ "./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-38626701\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./resources/assets/js/components/Salary.vue":
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", [
    _c("div", { staticClass: "box" }, [
      _vm._m(0),
      _vm._v(" "),
      _c("div", { staticClass: "box-body" }, [
        _c("div", { staticClass: "form-group flex form-group_w20 " }, [
          _c("div", { staticClass: "form-item form-item_bold mr-5" }, [
            _c("p", [_vm._v("Фикс ЗП")]),
            _vm._v(" "),
            _c(
              "button",
              {
                staticClass: "btn mr-1",
                class: { "btn-success": _vm.changeData.fixSalary },
                attrs: { type: "button" },
                on: {
                  click: function($event) {
                    _vm.changeData.fixSalary = true
                  }
                }
              },
              [_vm._v("Да")]
            ),
            _vm._v(" "),
            _c(
              "button",
              {
                staticClass: "btn",
                class: { "btn-success": !_vm.changeData.fixSalary },
                attrs: { type: "button" },
                on: {
                  click: function($event) {
                    _vm.changeData.fixSalary = false
                  }
                }
              },
              [_vm._v("Нет")]
            )
          ]),
          _vm._v(" "),
          _c("div", { staticClass: "form-item form-item_bold" }, [
            _c("label", { attrs: { for: "coef" } }, [_vm._v("Коэффициент")]),
            _vm._v(" "),
            _c("input", {
              directives: [
                {
                  name: "model",
                  rawName: "v-model",
                  value: _vm.changeData.coef,
                  expression: "changeData.coef"
                }
              ],
              staticClass: "form-control",
              attrs: { type: "text", placeholder: "Коэффициент", id: "coef" },
              domProps: { value: _vm.changeData.coef },
              on: {
                input: function($event) {
                  if ($event.target.composing) {
                    return
                  }
                  _vm.$set(_vm.changeData, "coef", $event.target.value)
                }
              }
            })
          ])
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "form-group flex form-group_w20 " }, [
          _c("div", { staticClass: "form-item form-item_bold mr-5" }, [
            _c("label", { attrs: { for: "hour" } }, [_vm._v("Стоимость часа")]),
            _vm._v(" "),
            _c("div", { staticClass: "flex" }, [
              _c("input", {
                staticClass: "form-control mr-1",
                attrs: {
                  type: "text",
                  name: "hours",
                  placeholder: "Стоимость часа",
                  disabled: ""
                },
                domProps: { value: _vm.staticData.salaryHour }
              }),
              _vm._v(" "),
              _c("input", {
                directives: [
                  {
                    name: "model",
                    rawName: "v-model",
                    value: _vm.changeData.salaryHour,
                    expression: "changeData.salaryHour"
                  }
                ],
                staticClass: "form-control",
                attrs: {
                  type: "text",
                  id: "hour",
                  placeholder: "Стоимость часа"
                },
                domProps: { value: _vm.changeData.salaryHour },
                on: {
                  input: [
                    function($event) {
                      if ($event.target.composing) {
                        return
                      }
                      _vm.$set(
                        _vm.changeData,
                        "salaryHour",
                        $event.target.value
                      )
                    },
                    function($event) {
                      _vm.onChangeSalaryHour($event)
                    }
                  ]
                }
              })
            ])
          ]),
          _vm._v(" "),
          _c("div", { staticClass: "form-item form-item_bold" }, [
            _c("label", { attrs: { for: "closeHour" } }, [
              _vm._v("Закрыто часов")
            ]),
            _vm._v(" "),
            _c("div", { staticClass: "flex" }, [
              _c("input", {
                staticClass: "form-control mr-1",
                attrs: {
                  type: "text",
                  name: "close_hours",
                  placeholder: "Закрыто часов",
                  disabled: ""
                },
                domProps: { value: _vm.staticData.closeHours }
              }),
              _vm._v(" "),
              _c("input", {
                directives: [
                  {
                    name: "model",
                    rawName: "v-model.number",
                    value: _vm.changeData.closeHours,
                    expression: "changeData.closeHours",
                    modifiers: { number: true }
                  }
                ],
                staticClass: "form-control",
                attrs: {
                  type: "text",
                  id: "closeHour",
                  placeholder: "Закрыто часов"
                },
                domProps: { value: _vm.changeData.closeHours },
                on: {
                  input: function($event) {
                    if ($event.target.composing) {
                      return
                    }
                    _vm.$set(
                      _vm.changeData,
                      "closeHours",
                      _vm._n($event.target.value)
                    )
                  },
                  blur: function($event) {
                    _vm.$forceUpdate()
                  }
                }
              })
            ])
          ])
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "form-group flex form-group_w20 " }, [
          _c("div", { staticClass: "form-item form-item_bold mr-5" }, [
            _c("label", { attrs: { for: "fineHours" } }, [
              _vm._v("Штрафных часов")
            ]),
            _vm._v(" "),
            _c("div", { staticClass: "flex" }, [
              _c("input", {
                staticClass: "form-control mr-1",
                attrs: {
                  type: "text",
                  placeholder: "Штрафных часов",
                  disabled: ""
                },
                domProps: { value: _vm.staticData.penaltyTime }
              }),
              _vm._v(" "),
              _c("input", {
                directives: [
                  {
                    name: "model",
                    rawName: "v-model",
                    value: _vm.changeData.penaltyTime,
                    expression: "changeData.penaltyTime"
                  }
                ],
                staticClass: "form-control",
                attrs: {
                  type: "text",
                  placeholder: "Штрафных часов",
                  id: "fineHours"
                },
                domProps: { value: _vm.changeData.penaltyTime },
                on: {
                  input: function($event) {
                    if ($event.target.composing) {
                      return
                    }
                    _vm.$set(_vm.changeData, "penaltyTime", $event.target.value)
                  }
                }
              })
            ])
          ]),
          _vm._v(" "),
          _c("div", { staticClass: "form-item form-item_bold" }, [
            _c("label", { attrs: { for: "zp" } }, [_vm._v("ЗП")]),
            _vm._v(" "),
            _c("div", { staticClass: "flex" }, [
              _c("input", {
                staticClass: "form-control mr-1",
                attrs: { type: "text", placeholder: "Зарплата", disabled: "" },
                domProps: { value: _vm.staticData.salary }
              }),
              _vm._v(" "),
              _c("input", {
                directives: [
                  {
                    name: "model",
                    rawName: "v-model",
                    value: _vm.changeData.salary,
                    expression: "changeData.salary"
                  }
                ],
                staticClass: "form-control",
                attrs: { type: "text", id: "zp", placeholder: "Зарплата" },
                domProps: { value: _vm.changeData.salary },
                on: {
                  input: [
                    function($event) {
                      if ($event.target.composing) {
                        return
                      }
                      _vm.$set(_vm.changeData, "salary", $event.target.value)
                    },
                    function($event) {
                      _vm.onChangeSalary($event)
                    }
                  ]
                }
              })
            ])
          ])
        ]),
        _vm._v(" "),
        _c(
          "button",
          {
            staticClass: "btn btn-primary w-15",
            attrs: { type: "button" },
            on: {
              click: function($event) {
                _vm.saveSalary()
              }
            }
          },
          [_vm._v("Сохранить")]
        )
      ])
    ])
  ])
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "box-header with-border" }, [
      _c("h3", { staticClass: "box-title" }, [
        _vm._v("\n                Зарплата\n            ")
      ])
    ])
  }
]
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-38626701", module.exports)
  }
}

/***/ }),

/***/ "./node_modules/vue-style-loader/index.js!./node_modules/css-loader/index.js!./node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-38626701\",\"scoped\":false,\"hasInlineConfig\":true}!./node_modules/vue-loader/lib/selector.js?type=styles&index=0!./resources/assets/js/components/Salary.vue":
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__("./node_modules/css-loader/index.js!./node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-38626701\",\"scoped\":false,\"hasInlineConfig\":true}!./node_modules/vue-loader/lib/selector.js?type=styles&index=0!./resources/assets/js/components/Salary.vue");
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__("./node_modules/vue-style-loader/lib/addStylesClient.js")("e31618b8", content, false, {});
// Hot Module Replacement
if(false) {
 // When the styles change, update the <style> tags
 if(!content.locals) {
   module.hot.accept("!!../../../../node_modules/css-loader/index.js!../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-38626701\",\"scoped\":false,\"hasInlineConfig\":true}!../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./Salary.vue", function() {
     var newContent = require("!!../../../../node_modules/css-loader/index.js!../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-38626701\",\"scoped\":false,\"hasInlineConfig\":true}!../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./Salary.vue");
     if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];
     update(newContent);
   });
 }
 // When the module is disposed, remove the <style> tags
 module.hot.dispose(function() { update(); });
}

/***/ }),

/***/ "./resources/assets/js/components/Salary.vue":
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__("./node_modules/vue-style-loader/index.js!./node_modules/css-loader/index.js!./node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-38626701\",\"scoped\":false,\"hasInlineConfig\":true}!./node_modules/vue-loader/lib/selector.js?type=styles&index=0!./resources/assets/js/components/Salary.vue")
}
var normalizeComponent = __webpack_require__("./node_modules/vue-loader/lib/component-normalizer.js")
/* script */
var __vue_script__ = __webpack_require__("./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"],\"uglify\":true}}]],\"plugins\":[\"transform-object-rest-spread\",[\"transform-runtime\",{\"polyfill\":false,\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./resources/assets/js/components/Salary.vue")
/* template */
var __vue_template__ = __webpack_require__("./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-38626701\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./resources/assets/js/components/Salary.vue")
/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = injectStyle
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __vue_script__,
  __vue_template__,
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "resources\\assets\\js\\components\\Salary.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-38626701", Component.options)
  } else {
    hotAPI.reload("data-v-38626701", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ })

});