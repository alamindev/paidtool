<aside class="left-sidebar">
    <ul id="slide-out" class="sidenav p-t-20">
        <li>
            <ul class="collapsible">
                <li>
                    <a href='{{ route("packages")}}' class="collapsible-header"><i class="material-icons">collections</i><span class="hide-menu">Package</span></a>
                </li>
                <li>
                    <a href='{{ route("addPackage")}}' class="collapsible-header"><i class="material-icons">add_to_photos</i><span class="hide-menu">Add Package</span></a>
                </li>
                <li>
                    <a href="{{route('tasks')}}" class="collapsible-header"><i class="material-icons">format_list_bulleted</i><span class="hide-menu">Tasks</span></a>
                </li> 
                <li>
                    <a href="{{route('addurltask')}}" class="collapsible-header"><i class="material-icons">add_to_photos</i><span class="hide-menu">Add Url Task</span></a>
                </li>
                <!-- <li>
                <a href="{{route('tickets')}}" class="collapsible-header"><i class="material-icons">bookmark_border</i><span class="hide-menu">Ticket List</span></a>
                </li> -->
                <li>
                <a href="{{route('users')}}" class="collapsible-header"><i class="material-icons">supervisor_account</i><span class="hide-menu">Users</span></a>
                </li>
                <li>
                <a href="{{route('subscriptions')}}" class="collapsible-header"><i class="material-icons">layers</i><span class="hide-menu">Subscriptions</span></a>
                </li>
                <li>
                <a href="{{route('withdrawls')}}" class="collapsible-header"><i class="material-icons">account_balance_wallet</i><span class="hide-menu">Withdrawls</span></a>
                </li>
                <li>
                <a href="{{route('payments')}}" class="collapsible-header"><i class="material-icons">monetization_on</i><span class="hide-menu">Payment History</span></a>
                </li>
                <li>
                <a href="{{route('notice')}}" class="collapsible-header"><i class="material-icons">monetization_on</i><span class="hide-menu">Notice Board</span></a>
                </li>
                <li>
                <a href="{{route('settings')}}" class="collapsible-header"><i class="material-icons">settings_input_component</i><span class="hide-menu">Settings</span></a>
                </li>
            </ul>
        </li>
    </ul>
</aside>