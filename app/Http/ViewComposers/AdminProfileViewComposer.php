<?php
namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\Models\CmsManage\Admin;
use App\Models\CmsManage\Role;
use Illuminate\Support\Facades\Auth;

class AdminProfileViewComposer
{
	protected $admin;
	protected $role;

	public function __construct()
	{
		$this->admin = Auth::user();
		$this->role = null;
		if($this->admin) $this->role = $this->admin->role;
	}

	public function compose(View $view)
	{
		$view->with('authenticatedAdmin', $this->admin);
		$view->with('authenticatedAdminRole', $this->role);

	}
}

?>
