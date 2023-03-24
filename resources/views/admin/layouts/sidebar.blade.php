{{-- <div class="d-flex align-items-center navbar-height">
    <form action="index.html"
            class="search-form search-form--black mx-16pt pr-0 pl-16pt">
        <input type="text"
                class="form-control pl-0"
                placeholder="Search">
        <button class="btn"
                type="submit"><i class="material-icons">search</i></button>
    </form>
</div> --}}

<a href="index.html" class="sidebar-brand ">
    <!-- <img class="sidebar-brand-icon" src="../../public/images/illustration/student/128/white.svg" alt="Luma"> -->

    <span class="avatar avatar-xl sidebar-brand-icon h-auto">

        <span class="avatar-title rounded bg-primary"><img
                src="{{ asset('/assets/images/illustration/student/128/white.svg') }}" class="img-fluid"
                alt="logo" /></span>

    </span>

    <span>{{ env('APP_NAME') }}</span>
</a>

<div class="sidebar-heading">Instructor</div>
<ul class="sidebar-menu">

    {{-- <li class="sidebar-menu-item">
        <a class="sidebar-menu-button"
            href="index.html">
            <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">home</span>
            <span class="sidebar-menu-text">Home</span>
        </a>
    </li> --}}
    {{-- <li class="sidebar-menu-item">
        <a class="sidebar-menu-button"
            href="{{ route('course.index') }}">
            <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">local_library</span>
            <span class="sidebar-menu-text">Cari Kursus</span>
        </a>
    </li> --}}
    {{-- <li class="sidebar-menu-item">
        <a class="sidebar-menu-button"
            href="paths.html">
            <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">style</span>
            <span class="sidebar-menu-text">Browse Paths</span>
        </a>
    </li> --}}
<<<<<<< HEAD
    <li class="sidebar-menu-item active">
        <a class="sidebar-menu-button" href="{{ route('admin.dashboard.index') }}">
=======
    <li class="sidebar-menu-item {{ Request::segment(1) == 'admin' && Request::segment(2) === null ? 'active' : '' }}">
        <a class="sidebar-menu-button"
            href="{{ route('admin.dashboard.index') }}">
>>>>>>> 41afe7b466e6580738e08754d2a0d7fa471c7d0d
            <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">account_box</span>
            <span class="sidebar-menu-text">Dashboard</span>
        </a>
    </li>

    <ul class="sidebar-menu">
<<<<<<< HEAD
        <li class="sidebar-menu-item">
            <a class="sidebar-menu-button" data-toggle="collapse" href="#master_data_menu">
=======
        <li class="sidebar-menu-item {{ Request::segment(2) == 'master_data' ? 'active' : '' }}
        
        {{
            Request::segment(3) == 'group_category_course' || 
            Request::segment(3) == 'category_course' || 
            Request::segment(3) == 'level' || 
            Request::segment(3) == 'course' ? 'open': ''
        }}">
            <a class="sidebar-menu-button"
                data-toggle="collapse"
                href="#master_data_menu">
>>>>>>> 41afe7b466e6580738e08754d2a0d7fa471c7d0d
                <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">folder</span>
                Master Data
                <span class="ml-auto sidebar-menu-toggle-icon"></span>
            </a>
<<<<<<< HEAD
            <ul class="sidebar-submenu collapse sm-indent" id="master_data_menu">
                <li class="sidebar-menu-item">
                    <?php $name = 'course'; ?>
                    <a class="sidebar-menu-button" href="{{ route('admin.' . $name . '.index') }}">
                        <span class="sidebar-menu-text">{{ master_sidebar($name) }}</span>
                    </a>
                </li>
                <li class="sidebar-menu-item">
                    <?php $name = 'offline_course'; ?>
                    <a class="sidebar-menu-button" href="{{ route('admin.' . $name . '.index') }}">
                        <span class="sidebar-menu-text">{{ master_sidebar($name) }}</span>
                    </a>
                </li>
                <li class="sidebar-menu-item">
                    <?php $name = 'group_category_course'; ?>
                    <a class="sidebar-menu-button" href="{{ route('admin.' . $name . '.index') }}">
                        <span class="sidebar-menu-text">{{ master_sidebar($name) }}</span>
                    </a>
                </li>
                <li class="sidebar-menu-item">
                    <?php $name = 'category_course'; ?>
                    <a class="sidebar-menu-button" href="{{ route('admin.' . $name . '.index') }}">
                        <span class="sidebar-menu-text">{{ master_sidebar($name) }}</span>
                    </a>
                </li>
                <li class="sidebar-menu-item">
                    <?php $name = 'level'; ?>
                    <a class="sidebar-menu-button" href="{{ route('admin.' . $name . '.index') }}">
=======
            <ul class="sidebar-submenu collapse sm-indent "
                id="master_data_menu">
                <?php $name = 'group_category_course' ?>
                <li class="sidebar-menu-item {{ Request::segment(3) == $name ? 'active' : '' }}">
                    <a class="sidebar-menu-button"
                        href="{{ route('admin.'.$name.'.index') }}">
                        <span class="sidebar-menu-text">{{ master_sidebar($name) }}</span>
                    </a>
                </li>
                <?php $name = 'category_course' ?>
                <li class="sidebar-menu-item {{ Request::segment(3) == $name ? 'active' : '' }}">
                    <a class="sidebar-menu-button"
                        href="{{ route('admin.'.$name.'.index') }}">
                        <span class="sidebar-menu-text">{{ master_sidebar($name) }}</span>
                    </a>
                </li>
                <?php $name = 'level' ?>
                <li class="sidebar-menu-item {{ Request::segment(3) == $name ? 'active' : '' }}">
                    <a class="sidebar-menu-button"
                        href="{{ route('admin.'.$name.'.index') }}">
                        <span class="sidebar-menu-text">{{ master_sidebar($name) }}</span>
                    </a>
                </li>
                <?php $name = 'course' ?>
                <li class="sidebar-menu-item {{ Request::segment(3) == $name ? 'active' : '' }}">
                    <a class="sidebar-menu-button"
                        href="{{ route('admin.'.$name.'.index') }}">
>>>>>>> 41afe7b466e6580738e08754d2a0d7fa471c7d0d
                        <span class="sidebar-menu-text">{{ master_sidebar($name) }}</span>
                    </a>
                </li>
            </ul>
        </li>
    </ul>

    {{-- <li class="sidebar-menu-item">
        <a class="sidebar-menu-button"
            href="student-my-courses.html">
            <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">search</span>
            <span class="sidebar-menu-text">My Courses</span>
        </a>
    </li> --}}
    {{-- <li class="sidebar-menu-item">
        <a class="sidebar-menu-button"
            href="student-paths.html">
            <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">timeline</span>
            <span class="sidebar-menu-text">My Paths</span>
        </a>
    </li> --}}
    {{-- <li class="sidebar-menu-item">
        <a class="sidebar-menu-button"
            href="student-path.html">
            <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">change_history</span>
            <span class="sidebar-menu-text">Path Details</span>
        </a>
    </li> --}}
    {{-- <li class="sidebar-menu-item">
        <a class="sidebar-menu-button"
            href="student-course.html">
            <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">face</span>
            <span class="sidebar-menu-text">Course Preview</span>
        </a>
    </li> --}}
    {{-- <li class="sidebar-menu-item">
        <a class="sidebar-menu-button"
            href="student-lesson.html">
            <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">panorama_fish_eye</span>
            <span class="sidebar-menu-text">Lesson Preview</span>
        </a>
    </li> --}}
    {{-- <li class="sidebar-menu-item">
        <a class="sidebar-menu-button"
            href="student-take-course.html">
            <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">class</span>
            <span class="sidebar-menu-text">Take Course</span>
            <span class="sidebar-menu-badge badge badge-accent badge-notifications ml-auto">PRO</span>
        </a>
    </li> --}}
    {{-- <li class="sidebar-menu-item">
        <a class="sidebar-menu-button"
            href="student-take-lesson.html">
            <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">import_contacts</span>
            <span class="sidebar-menu-text">Take Lesson</span>
        </a>
    </li> --}}
    {{-- <li class="sidebar-menu-item">
        <a class="sidebar-menu-button"
            href="student-take-quiz.html">
            <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">dvr</span>
            <span class="sidebar-menu-text">Take Quiz</span>
        </a>
    </li> --}}
    {{-- <li class="sidebar-menu-item">
        <a class="sidebar-menu-button"
            href="student-quiz-results.html">
            <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">poll</span>
            <span class="sidebar-menu-text">My Quizzes</span>
        </a>
    </li> --}}
    {{-- <li class="sidebar-menu-item">
        <a class="sidebar-menu-button"
            href="student-quiz-result-details.html">
            <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">live_help</span>
            <span class="sidebar-menu-text">Quiz Result</span>
        </a>
    </li> --}}
    {{-- <li class="sidebar-menu-item">
        <a class="sidebar-menu-button"
            href="student-path-assessment.html">
            <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">layers</span>
            <span class="sidebar-menu-text">Skill Assessment</span>
        </a>
    </li> --}}
    {{-- <li class="sidebar-menu-item">
        <a class="sidebar-menu-button"
            href="student-path-assessment-result.html">
            <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">assignment_turned_in</span>
            <span class="sidebar-menu-text">Skill Result</span>
        </a>
    </li> --}}

</ul>

{{-- <div class="sidebar-heading">Instructor</div>
<ul class="sidebar-menu">

    <li class="sidebar-menu-item">
        <a class="sidebar-menu-button"
            href="instructor-dashboard.html">
            <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">school</span>
            <span class="sidebar-menu-text">Instructor Dashboard</span>
        </a>
    </li>
    <li class="sidebar-menu-item">
        <a class="sidebar-menu-button"
            href="instructor-courses.html">
            <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">import_contacts</span>
            <span class="sidebar-menu-text">Manage Courses</span>
        </a>
    </li>
    <li class="sidebar-menu-item">
        <a class="sidebar-menu-button"
            href="instructor-quizzes.html">
            <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">help</span>
            <span class="sidebar-menu-text">Manage Quizzes</span>
        </a>
    </li>
    <li class="sidebar-menu-item">
        <a class="sidebar-menu-button"
            href="instructor-earnings.html">
            <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">trending_up</span>
            <span class="sidebar-menu-text">Earnings</span>
        </a>
    </li>
    <li class="sidebar-menu-item">
        <a class="sidebar-menu-button"
            href="instructor-statement.html">
            <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">receipt</span>
            <span class="sidebar-menu-text">Statement</span>
        </a>
    </li>
    <li class="sidebar-menu-item">
        <a class="sidebar-menu-button"
            href="instructor-edit-course.html">
            <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">post_add</span>
            <span class="sidebar-menu-text">Edit Course</span>
        </a>
    </li>
    <li class="sidebar-menu-item">
        <a class="sidebar-menu-button"
            href="instructor-edit-quiz.html">
            <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">format_shapes</span>
            <span class="sidebar-menu-text">Edit Quiz</span>
        </a>
    </li>

</ul> --}}

{{-- <div class="sidebar-heading">Applications</div>
<ul class="sidebar-menu">

    <li class="sidebar-menu-item">
        <a class="sidebar-menu-button js-sidebar-collapse"
            data-toggle="collapse"
            href="#enterprise_menu">
            <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">donut_large</span>
            Enterprise
            <span class="ml-auto sidebar-menu-toggle-icon"></span>
        </a>
        <ul class="sidebar-submenu collapse sm-indent"
            id="enterprise_menu">
            <li class="sidebar-menu-item">
                <a class="sidebar-menu-button"
                    href="erp-dashboard.html">
                    <span class="sidebar-menu-text">ERP Dashboard</span>
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a class="sidebar-menu-button"
                    href="crm-dashboard.html">
                    <span class="sidebar-menu-text">CRM Dashboard</span>
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a class="sidebar-menu-button"
                    href="hr-dashboard.html">
                    <span class="sidebar-menu-text">HR Dashboard</span>
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a class="sidebar-menu-button"
                    href="employees.html">
                    <span class="sidebar-menu-text">Employees</span>
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a class="sidebar-menu-button"
                    href="staff.html">
                    <span class="sidebar-menu-text">Staff</span>
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a class="sidebar-menu-button"
                    href="leaves.html">
                    <span class="sidebar-menu-text">Leaves</span>
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a class="sidebar-menu-button disabled"
                    href="departments.html">
                    <span class="sidebar-menu-text">Departments</span>
                </a>
            </li>
        </ul>
    </li>
    <li class="sidebar-menu-item">
        <a class="sidebar-menu-button"
            data-toggle="collapse"
            href="#productivity_menu">
            <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">access_time</span>
            Productivity
            <span class="ml-auto sidebar-menu-toggle-icon"></span>
        </a>
        <ul class="sidebar-submenu collapse sm-indent"
            id="productivity_menu">
            <li class="sidebar-menu-item">
                <a class="sidebar-menu-button"
                    href="projects.html">
                    <span class="sidebar-menu-text">Projects</span>
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a class="sidebar-menu-button"
                    href="tasks-board.html">
                    <span class="sidebar-menu-text">Tasks Board</span>
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a class="sidebar-menu-button"
                    href="tasks-list.html">
                    <span class="sidebar-menu-text">Tasks List</span>
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a class="sidebar-menu-button disabled"
                    href="kanban.html">
                    <span class="sidebar-menu-text">Kanban</span>
                </a>
            </li>
        </ul>
    </li>
    <li class="sidebar-menu-item">
        <a class="sidebar-menu-button"
            data-toggle="collapse"
            href="#ecommerce_menu">
            <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">shopping_cart</span>
            eCommerce
            <span class="ml-auto sidebar-menu-toggle-icon"></span>
        </a>
        <ul class="sidebar-submenu collapse sm-indent"
            id="ecommerce_menu">
            <li class="sidebar-menu-item">
                <a class="sidebar-menu-button"
                    href="ecommerce.html">
                    <span class="sidebar-menu-text">Shop Dashboard</span>
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a class="sidebar-menu-button disabled"
                    href="edit-product.html">
                    <span class="sidebar-menu-text">Edit Product</span>
                </a>
            </li>
        </ul>
    </li>
    <li class="sidebar-menu-item">
        <a class="sidebar-menu-button"
            data-toggle="collapse"
            href="#messaging_menu">
            <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">message</span>
            Messaging
            <span class="sidebar-menu-badge badge badge-accent badge-notifications ml-auto">2</span>
            <span class="sidebar-menu-toggle-icon"></span>
        </a>
        <ul class="sidebar-submenu collapse sm-indent"
            id="messaging_menu">
            <li class="sidebar-menu-item">
                <a class="sidebar-menu-button"
                    href="messages.html">
                    <span class="sidebar-menu-text">Messages</span>
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a class="sidebar-menu-button"
                    href="email.html">
                    <span class="sidebar-menu-text">Email</span>
                </a>
            </li>
        </ul>
    </li>
    <li class="sidebar-menu-item">
        <a class="sidebar-menu-button"
            data-toggle="collapse"
            href="#cms_menu">
            <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">content_copy</span>
            CMS
            <span class="ml-auto sidebar-menu-toggle-icon"></span>
        </a>
        <ul class="sidebar-submenu collapse sm-indent"
            id="cms_menu">
            <li class="sidebar-menu-item">
                <a class="sidebar-menu-button"
                    href="cms-dashboard.html">
                    <span class="sidebar-menu-text">CMS Dashboard</span>
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a class="sidebar-menu-button"
                    href="posts.html">
                    <span class="sidebar-menu-text">Posts</span>
                </a>
            </li>
        </ul>
    </li>
    <li class="sidebar-menu-item">
        <a class="sidebar-menu-button"
            data-toggle="collapse"
            href="#account_menu">
            <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">account_box</span>
            Account
            <span class="ml-auto sidebar-menu-toggle-icon"></span>
        </a>
        <ul class="sidebar-submenu collapse sm-indent"
            id="account_menu">
            <li class="sidebar-menu-item">
                <a class="sidebar-menu-button"
                    href="pricing.html">
                    <span class="sidebar-menu-text">Pricing</span>
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a class="sidebar-menu-button"
                    href="login.html">
                    <span class="sidebar-menu-text">Login</span>
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a class="sidebar-menu-button"
                    href="signup.html">
                    <span class="sidebar-menu-text">Signup</span>
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a class="sidebar-menu-button"
                    href="signup-payment.html">
                    <span class="sidebar-menu-text">Payment</span>
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a class="sidebar-menu-button"
                    href="reset-password.html">
                    <span class="sidebar-menu-text">Reset Password</span>
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a class="sidebar-menu-button"
                    href="change-password.html">
                    <span class="sidebar-menu-text">Change Password</span>
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a class="sidebar-menu-button"
                    href="edit-account.html">
                    <span class="sidebar-menu-text">Edit Account</span>
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a class="sidebar-menu-button"
                    href="edit-account-profile.html">
                    <span class="sidebar-menu-text">Profile &amp; Privacy</span>
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a class="sidebar-menu-button"
                    href="edit-account-notifications.html">
                    <span class="sidebar-menu-text">Email Notifications</span>
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a class="sidebar-menu-button"
                    href="edit-account-password.html">
                    <span class="sidebar-menu-text">Account Password</span>
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a class="sidebar-menu-button"
                    href="billing.html">
                    <span class="sidebar-menu-text">Subscription</span>
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a class="sidebar-menu-button"
                    href="billing-upgrade.html">
                    <span class="sidebar-menu-text">Upgrade Account</span>
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a class="sidebar-menu-button"
                    href="billing-payment.html">
                    <span class="sidebar-menu-text">Payment Information</span>
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a class="sidebar-menu-button"
                    href="billing-history.html">
                    <span class="sidebar-menu-text">Payment History</span>
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a class="sidebar-menu-button"
                    href="billing-invoice.html">
                    <span class="sidebar-menu-text">Invoice</span>
                </a>
            </li>
        </ul>
    </li>
    <li class="sidebar-menu-item">
        <a class="sidebar-menu-button"
            data-toggle="collapse"
            href="#community_menu">
            <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">people_outline</span>
            Community
            <span class="ml-auto sidebar-menu-toggle-icon"></span>
        </a>
        <ul class="sidebar-submenu collapse sm-indent"
            id="community_menu">
            <li class="sidebar-menu-item">
                <a class="sidebar-menu-button"
                    href="teachers.html">

                    <span class="sidebar-menu-text">Browse Teachers</span>
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a class="sidebar-menu-button"
                    href="student-profile.html">

                    <span class="sidebar-menu-text">Student Profile</span>
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a class="sidebar-menu-button"
                    href="teacher-profile.html">

                    <span class="sidebar-menu-text">Teacher Profile</span>
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a class="sidebar-menu-button"
                    href="blog.html">

                    <span class="sidebar-menu-text">Blog</span>
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a class="sidebar-menu-button"
                    href="blog-post.html">

                    <span class="sidebar-menu-text">Blog Post</span>
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a class="sidebar-menu-button"
                    href="faq.html">
                    <span class="sidebar-menu-text">FAQ</span>
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a class="sidebar-menu-button"
                    href="help-center.html">
                    <!--  -->
                    <span class="sidebar-menu-text">Help Center</span>
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a class="sidebar-menu-button"
                    href="discussions.html">
                    <span class="sidebar-menu-text">Discussions</span>
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a class="sidebar-menu-button"
                    href="discussion.html">
                    <span class="sidebar-menu-text">Discussion Details</span>
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a class="sidebar-menu-button"
                    href="discussions-ask.html">
                    <span class="sidebar-menu-text">Ask Question</span>
                </a>
            </li>
        </ul>
    </li>
</ul> --}}

{{-- <div class="sidebar-heading">UI</div>
<ul class="sidebar-menu">
    <li class="sidebar-menu-item">
        <a class="sidebar-menu-button"
            data-toggle="collapse"
            href="#components_menu">
            <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">tune</span>
            Components
            <span class="ml-auto sidebar-menu-toggle-icon"></span>
        </a>
        <ul class="sidebar-submenu collapse sm-indent"
            id="components_menu">
            <li class="sidebar-menu-item">
                <a class="sidebar-menu-button"
                    href="ui-buttons.html">
                    <span class="sidebar-menu-text">Buttons</span>
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a class="sidebar-menu-button"
                    href="ui-avatars.html">
                    <span class="sidebar-menu-text">Avatars</span>
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a class="sidebar-menu-button"
                    href="ui-forms.html">
                    <span class="sidebar-menu-text">Forms</span>
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a class="sidebar-menu-button"
                    href="ui-loaders.html">
                    <span class="sidebar-menu-text">Loaders</span>
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a class="sidebar-menu-button"
                    href="ui-tables.html">
                    <span class="sidebar-menu-text">Tables</span>
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a class="sidebar-menu-button"
                    href="ui-cards.html">
                    <span class="sidebar-menu-text">Cards</span>
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a class="sidebar-menu-button"
                    href="ui-icons.html">
                    <span class="sidebar-menu-text">Icons</span>
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a class="sidebar-menu-button"
                    href="ui-tabs.html">
                    <span class="sidebar-menu-text">Tabs</span>
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a class="sidebar-menu-button"
                    href="ui-alerts.html">
                    <span class="sidebar-menu-text">Alerts</span>
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a class="sidebar-menu-button"
                    href="ui-badges.html">
                    <span class="sidebar-menu-text">Badges</span>
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a class="sidebar-menu-button"
                    href="ui-progress.html">
                    <span class="sidebar-menu-text">Progress</span>
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a class="sidebar-menu-button"
                    href="ui-pagination.html">
                    <span class="sidebar-menu-text">Pagination</span>
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a class="sidebar-menu-button disabled"
                    href="">
                    <span class="sidebar-menu-text">Disabled</span>
                </a>
            </li>
        </ul>
    </li>
    <li class="sidebar-menu-item">
        <a class="sidebar-menu-button"
            data-toggle="collapse"
            href="#plugins_menu">
            <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">folder</span>
            Plugins
            <span class="ml-auto sidebar-menu-toggle-icon"></span>
        </a>
        <ul class="sidebar-submenu collapse sm-indent"
            id="plugins_menu">
            <li class="sidebar-menu-item">
                <a class="sidebar-menu-button"
                    href="ui-plugin-charts.html">
                    <span class="sidebar-menu-text">Charts</span>
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a class="sidebar-menu-button"
                    href="ui-plugin-flatpickr.html">
                    <span class="sidebar-menu-text">Flatpickr</span>
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a class="sidebar-menu-button"
                    href="ui-plugin-daterangepicker.html">
                    <span class="sidebar-menu-text">Date Range Picker</span>
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a class="sidebar-menu-button"
                    href="ui-plugin-dragula.html">
                    <span class="sidebar-menu-text">Dragula</span>
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a class="sidebar-menu-button"
                    href="ui-plugin-dropzone.html">
                    <span class="sidebar-menu-text">Dropzone</span>
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a class="sidebar-menu-button"
                    href="ui-plugin-range-sliders.html">
                    <span class="sidebar-menu-text">Range Sliders</span>
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a class="sidebar-menu-button"
                    href="ui-plugin-quill.html">
                    <span class="sidebar-menu-text">Quill</span>
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a class="sidebar-menu-button"
                    href="ui-plugin-select2.html">
                    <span class="sidebar-menu-text">Select2</span>
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a class="sidebar-menu-button"
                    href="ui-plugin-nestable.html">
                    <span class="sidebar-menu-text">Nestable</span>
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a class="sidebar-menu-button"
                    href="ui-plugin-fancytree.html">
                    <span class="sidebar-menu-text">Fancy Tree</span>
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a class="sidebar-menu-button"
                    href="ui-plugin-maps-vector.html">
                    <span class="sidebar-menu-text">Vector Maps</span>
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a class="sidebar-menu-button"
                    href="ui-plugin-sweet-alert.html">
                    <span class="sidebar-menu-text">Sweet Alert</span>
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a class="sidebar-menu-button"
                    href="ui-plugin-toastr.html">
                    <span class="sidebar-menu-text">Toastr</span>
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a class="sidebar-menu-button disabled"
                    href="">
                    <span class="sidebar-menu-text">Disabled</span>
                </a>
            </li>
        </ul>
    </li>
    <li class="sidebar-menu-item">
        <a class="sidebar-menu-button"
            data-toggle="collapse"
            href="#layouts_menu">
            <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">view_compact</span>
            Layouts
            <span class="ml-auto sidebar-menu-toggle-icon"></span>
        </a>
        <ul class="sidebar-submenu collapse sm-indent"
            id="layouts_menu">
            <li class="sidebar-menu-item">
                <a class="sidebar-menu-button"
                    href="../Compact_App_Layout/student-dashboard.html">
                    <span class="sidebar-menu-text">Compact</span>
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a class="sidebar-menu-button"
                    href="../Mini_App_Layout/student-dashboard.html">
                    <span class="sidebar-menu-text">Mini</span>
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a class="sidebar-menu-button"
                    href="../Mini_Secondary_Layout/student-dashboard.html">
                    <span class="sidebar-menu-text">Mini + Secondary</span>
                </a>
            </li>
            <li class="sidebar-menu-item active">
                <a class="sidebar-menu-button"
                    href="../App_Layout/student-dashboard.html">
                    <span class="sidebar-menu-text">App</span>
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a class="sidebar-menu-button"
                    href="../Boxed_App_Layout/student-dashboard.html">
                    <span class="sidebar-menu-text">Boxed</span>
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a class="sidebar-menu-button"
                    href="../Sticky_App_Layout/student-dashboard.html">
                    <span class="sidebar-menu-text">Sticky</span>
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a class="sidebar-menu-button"
                    href="../Fixed_Layout/student-dashboard.html">
                    <span class="sidebar-menu-text">Fixed</span>
                </a>
            </li>
        </ul>
    </li>
</ul> --}}
