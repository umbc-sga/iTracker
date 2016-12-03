<uib-accordion>
    <div uib-accordion-group class="panel-default box box-warning" data-ng-repeat="project in projects">
        <uib-accordion-heading class="text-center">
            @{{project.name}}
        </uib-accordion-heading>
        <div class="projectAtAGlance" data-project="project" data-read-more="readMore"></div>
    </div>
</uib-accordion>