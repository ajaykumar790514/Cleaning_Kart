
<div id="datatable">
    <div id="grid_table">
        <table class="jsgrid-table">
            <tr class="jsgrid-header-row">
                <th class="jsgrid-header-cell jsgrid-align-center">Site key</th>
                <th class="jsgrid-header-cell jsgrid-align-center">Secret key</th>
                <th class="jsgrid-header-cell jsgrid-align-center">Actions</th>
            </tr>
            
            <tr class="jsgrid-filter-row">
                <th class="jsgrid-cell jsgrid-align-center"><?=$recaptcha_data->site_key;?></th>
                <th class="jsgrid-cell jsgrid-align-center"><?=$recaptcha_data->secret_key;?></th>
                <td class="jsgrid-cell jsgrid-align-center">
                    <a href="javascript:void(0)" data-toggle="modal" data-target="#showModal" data-whatever="Update Recaptcha" data-url="<?=$update_url?><?=$recaptcha_data->id?>" >
                        <i class="fa fa-edit"></i>
                    </a>
                </td>
            </tr> 
        </table>

            
    </div>
</div>
