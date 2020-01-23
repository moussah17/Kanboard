KB.component('chart-project-task', function (containerElement, options) {
    this.render = function () {
        var columns = [];
        for (var i = 0; i < options.metrics.length; i++) {
            columns.push([options.metrics[i].task, options.metrics[i].spent]);
        }
        KB.dom(containerElement).add(KB.dom('div').attr('id', 'chart').build());

        c3.generate({
            data: {
                columns: columns,
                type : 'donut'
            }
        });
    };
});
