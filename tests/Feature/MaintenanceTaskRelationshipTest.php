<?php

namespace Tests\Feature;

use App\Models\MaintenanceRequest;
use App\Models\MaintenanceTask;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MaintenanceTaskRelationshipTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_maintenance_task_can_load_its_request(): void
    {
        $user = User::factory()->create();

        $request = MaintenanceRequest::create([
            'user_id' => $user->id,
            'title' => 'Air conditioner not cooling',
            'description' => 'The unit is running but the room remains warm.',
            'location' => 'Room 305',
            'urgency' => 'high',
            'status' => 'in_progress',
        ]);

        $task = MaintenanceTask::create([
            'request_id' => $request->id,
            'assigned_to' => $user->id,
            'assigned_by' => $user->id,
            'priority' => 'high',
            'status' => 'pending',
        ]);

        $this->assertNotNull($task->request);
        $this->assertSame($request->id, $task->request->id);
        $this->assertSame('Air conditioner not cooling', $task->request->title);
    }
}
