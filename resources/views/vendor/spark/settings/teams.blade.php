<spark-teams :user="user" :teams="teams" inline-template>
    <div>
        <!-- Create Team -->
        @if (Auth::user()->canCreateTeams() && Spark::createsAdditionalTeams())
            @include('spark::settings.teams.create-team')
        @endif

        <!-- Pending Invitations -->
        @include('spark::settings.teams.pending-invitations')

        <!-- Current Teams -->
        <div v-if="user && teams.length > 0">
            @include('spark::settings.teams.current-teams')
        </div>
    </div>
</spark-teams>
