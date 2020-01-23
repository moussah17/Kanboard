KB.component('chart-project-time-estimated', function (containerElement, options) {

    this.render = function () {
        var metrics = options.metrics;
        var plots = [options.label];
        var categories = [];
        $zz=[];
                for (var column_id in metrics) {
                plots.push((metrics[column_id]['estimated']));
                categories.push(column_id);
                $metr=metrics[column_id].tasks;
                for(var oneMetr in  $metr){
                    if($zz.includes(oneMetr)){
                        $zz.push([oneMetr,$metr[oneMetr]]);    
                    }else {
                        $zz.push([oneMetr,$metr[oneMetr]]);
                    }  
                }   
        }
        function plotsDisplay($zz){
            $indexl=0; $oldTitles =[];
            $oldTitles[0]=[$zz[0][0]];
            for(var oneVect in $zz){
                $existe=false;
                
            for(var title in $oldTitles){
                if(!$oldTitles[title].includes($zz[oneVect][0])){

                }else{
                    $existe=true;
                    $indexTitle=title;
                }
            } 
            if($existe===true){
                $oldTitles[$indexTitle].push($zz[oneVect][1]*3600);
            }else{
                $indexl++;
                $oldTitles[$indexl]=([$zz[oneVect][0],$zz[oneVect][1]*3600]);
            }
            
    
            }
            return $oldTitles;
        }
        $zz=plotsDisplay($zz);
        alert($zz);        
        KB.dom(containerElement).add(KB.dom('div').attr('id', 'chart').build());
        c3.generate({
            data: {
                columns: $zz, 
                type: 'bar'
            },
            bar: {
                width: {
                    ratio: 0.5
                },
            },
            axis: {
                x: {
                    type: 'category',
                    categories: categories
                },
                y: {
                    tick: {
                        format: KB.utils.formatDuration

                    }
                }
            },
            legend: {
                show: false
            }
        });
    };
});