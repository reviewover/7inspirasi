<div class="white_container">
	
	<h2 style="padding-bottom:20px;"><i class="fa fa-puzzle-piece"></i> <span>Plugins<?php // Lang::get('lang.plugins') ?></span></h2>
	<table class="table plugins">
        <thead>
        <tr>
            <th>Plugin Name</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>

            @foreach($plugins_available as $plugin)

                <?php $this_plugin = Plugin::where('slug', '=', $plugin['slug'])->first(); ?>
               
                    <tr>
                        <td><h2 style="margin-bottom:0px; padding-bottom:0px;">{{ $plugin['name'] }} <span style="font-size:14px;">V.{{ $plugin['version'] }}</span></h2>
                            <small>{{ $plugin['description'] }}</small>
                        </td>
                        @if(!empty($this_plugin->active) && $this_plugin->active == 1) 
                            <td><p>Active</p></td>
                            <td><a href="admin/plugin/deactivate/{{ $plugin['slug'] }}" class="btn btn-danger" style="display:inline; float:left; margin-right:10px;">De-activate</a><a href="admin/plugin/{{ $plugin['slug'] }}" class="btn btn-success"><i class="fa fa-cog"></i></a></td>
                        @else 
                            <td><p>Inactive</p></td>
                            <td><a href="admin/plugin/activate/{{ $plugin['slug'] }}" class="btn btn-primary">Activate</a></td> 
                        @endif</p></td>
                       
                    </tr>

            @endforeach

        </tbody>
    </table>
	<div style="clear:both"></div>
</div>