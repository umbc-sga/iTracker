<div class="content-wrapper" style="min-height: 775px;">
  <section class="content-header">
    <h1>Are you lost?</h1>
    <ol class="breadcrumb">
      <li class="active">404 error</li>
    </ol>
  </section>

  <section class="content">
    <div class="error-page text-center">
        <h2 class="headline">YO<span class="text-yellow">U M</span>UST <span class="text-yellow">B</span>E <span class="text-yellow">C</span>ONFUSED </h2>
        <h2>The page you are looking for does not exist</h2>
    </div>
     <div class="row">
        <h2 class="content-header">Check out what SGA is up to!</h2>
         <div class="col-lg-4 col-xs-12">
             <div class="numberBox"
                  data-color="bg-aqua"
                  data-title="Active Projects"
                  data-str="@{{ data.projects.length }}"
                  data-url="{{url('/projects')}}"
                  data-description="See What We Are Working On!"
                  data-icon="ion ion-compose"></div>
         </div>
         <div class="col-lg-4 col-xs-12">
             <div class="numberBox"
                  data-color="bg-yellow"
                  data-title="Departments"
                  data-str="@{{ data.groups.length }}"
                  data-url="{{url('/departments')}}"
                  data-description="See Departmental Projects!"
                  data-icon="ion ion-briefcase"></div>
         </div>
         <div class="col-lg-4 col-xs-12">
             <div class="numberBox"
                  data-color="bg-red"
                  data-title="Active Members"
                  data-str="@{{ data.people.length }}"
                  data-url="{{url('/people')}}"
                  data-description="See Who Is Who!"
                  data-icon="ion ion-person"></div>
         </div>
    </div>
  </section>
</div>
