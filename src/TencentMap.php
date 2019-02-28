<?php

namespace Jxlwqq\TencentMap;

use Encore\Admin\Form\Field;

class TencentMap extends Field
{
    /**
     * Column name.
     *
     * @var array
     */
    protected $column = [];


    /**
     * @var string
     */
    protected $view = 'laravel-admin-tencent-map::map';

    /**
     * Map height.
     *
     * @var int
     */
    protected $height = 300;

    /**
     * @var int
     */
    protected $zoom = 13;

    /**
     * Get assets required by this field.
     *
     * @return array
     */
    public static function getAssets()
    {
        return ['js' => sprintf('//map.qq.com/api/js?v=2.exp&key=%s', config('admin.extensions.tencent-map.api_key'))];
    }

    /**
     * TencentMap constructor.
     *
     * @param string $column
     * @param array $arguments
     */
    public function __construct($column, $arguments)
    {
        $this->column['lat'] = (string)$column;
        $this->column['lng'] = (string)$arguments[0];

        array_shift($arguments);

        $this->label = $this->formatLabel($arguments);
        $this->id = $this->formatId($this->column);
    }

    /**
     * Set map height.
     *
     * @param int $height
     * @return $this
     */
    public function height($height = 300)
    {
        $this->height = $height;

        return $this;
    }

    public function zoom($zoom = 13)
    {
        $this->zoom = $zoom;

        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
     */
    public function render()
    {
        $this->script = $this->applyScript($this->id, $this->zoom);

        return parent::render()->with(['height' => $this->height]);


    }

    public function applyScript(array $id, int $zoom)
    {
        return <<<EOT
(function() {

    var searchService,map,markers = [];

    $('#map_search').click(function() {
        var keyword = document.getElementById("keyword").value;
        clearOverlays(markers);
        searchService.search(keyword);

    })

    function clearOverlays(overlays){
        var overlay;
        while(overlay = overlays.pop()){
            overlay.setMap(null);
        }
    }

    function init(name) {
        var lat = $('#{$id['lat']}');
        var lng = $('#{$id['lng']}');
        var center = new qq.maps.LatLng(lat.val() ? lat.val() : 39.916527, lng.val() ? lng.val() : 116.397128);
        var container = document.getElementById("map_"+name);
        var map = new qq.maps.Map(container, {
            center: center,
            zoom: {$zoom}
        });

        var latlngBounds = new qq.maps.LatLngBounds();
        //调用Poi检索类
        searchService = new qq.maps.SearchService({
            complete : function(results){
                var pois = results.detail.pois;
                for(var i = 0,l = pois.length;i < l; i++){
                    var poi = pois[i];
                    latlngBounds.extend(poi.latLng);
                    var marker = new qq.maps.Marker({
                        map:map,
                        position: poi.latLng
                    });

                    marker.setTitle(i+1);

                    markers.push(marker);
                }
                map.fitBounds(latlngBounds);
            }
        });

        var anchor = new qq.maps.Point(6, 6),
            size = new qq.maps.Size(24, 24),
            origin = new qq.maps.Point(0, 0),
            icon = new qq.maps.MarkerImage('https://lbs.qq.com/javascript_v2/img/center.gif', size, origin, anchor);
        var marker = new qq.maps.Marker({
            position: center,
            map: map,
            draggable: true,
            icon: icon
        });

        qq.maps.event.addListener(marker,'dragend',function(event) {
            lat.val(event.latLng.getLat());
            lng.val(event.latLng.getLng());
        });
        qq.maps.event.addListener(map, 'click', function(event) {
            marker.setPosition(event.latLng);
            lat.val(event.latLng.getLat());
            lng.val(event.latLng.getLng());
        });
    }
    init('{$id['lat']}{$id['lng']}');
})();
EOT;

    }
}
