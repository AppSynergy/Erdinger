

jsPlumb.bind("ready", function() {	
    
    // some defaults
    jsPlumb.importDefaults({
        Endpoint : ["Dot", {radius:1}],
        EndpointStyle : { fillStyle : null },
        Connector: [ "Flowchart", { stub:[10,10], gap: 5 } ],
        PaintStyle: { lineWidth:2, strokeStyle:'#555' },
        ConnectionOverlays : [
            [ "Diamond", { 
                location:1,
                id:"arrow",
                length:14,
                foldback:0.8
            } ],
        ]
    });

    // make elements draggable
    jsPlumb.draggable($(".erdingerClass"), {
        containment:"parent"
    });
    
    // endpoint options
    var endpointOptions = { 
        isSource:true, 
        isTarget:true,
        maxConnections: 10       
    };    
    
    // create endpoints
    erdEndPointVars = [];
    jQuery(erdEndPoints).each(function(i, ep) {
        erdEndPointVars[ep] = jsPlumb.addEndpoint(
            'erd'+ep,
            { anchor:"Continuous" },
            endpointOptions
        );
    });
    
    // create hasMany connections
    jQuery(erdHasManyConnections).each(function(i, conn) {
        jsPlumb.connect({ 
            source: erdEndPointVars[conn[0]],
            target: erdEndPointVars[conn[1]]        
        });
    });
    
    // create HABTM connections
    jQuery(erdHABTMConnections).each(function(i, conn) {
        jsPlumb.connect({ 
            source: erdEndPointVars[conn[0]],
            target: erdEndPointVars[conn[1]],
            paintStyle: { lineWidth:2, strokeStyle:'#F90' }
            
        });
    });  

});
