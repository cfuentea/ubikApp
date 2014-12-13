$(function() {

    Morris.Area({
        element: 'morris-area-chart',
        data: [{
            periodo: '2014 Q1',
            visitas: 2666
        }, {
            periodo: '2014 Q2',
            visitas: 2778
        }, {
            periodo: '2014 Q3',
            visitas: 4912
        }, {
            periodo: '2014 Q4',
            visitas: 3767
        }],
        xkey: 'periodo',
        ykeys: ['visitas'],
        labels: ['visitas'],
        pointSize: 2,
        //hideHover: 'auto',
        resize: false
    });

    Morris.Donut({
        element: 'morris-donut-chart',
        data: [{
            label: "Campañas activas",
            value: 1
        }, {
            label: "Campañas Pendientes",
            value: 0
        }, {
            label: "Campañas Canceladas",
            value: 0
        }],
        resize: true
    });

});
