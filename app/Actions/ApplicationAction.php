<?php

namespace App\Actions;

use App\DTOs\ApplicationDTO;
use App\Enums\Status;
use App\Models\DropshipperApplication;
use App\Models\DropshipperStore;
use Exception;
use Illuminate\Support\Facades\DB;
use Throwable;

class ApplicationAction
{
    /**
     * @throws Exception|Throwable
     */
    public static function execute(ApplicationDTO $dto): DropshipperApplication
    {
        $user = auth()->user();

        if (! $user) {
            throw new Exception('User not found.');
        }

        $dropshipper = auth()->user()->dropshipper;
        if (! $dropshipper) {
            throw new Exception('Dropshipper not found.');
        }

        DB::beginTransaction();
        try {
            $application = DropshipperApplication::create([
                'dropshipper_id' => $dropshipper->id,
                'brand_id' => $dto->brandId,
                'notes' => $dto->notes,
                'status' => Status::PENDING,
            ]);
            DB::commit();

            return $application;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new Exception("Failed to submit application {$e->getMessage()}");
        }

    }

    /**
     * @throws Throwable
     */
    public static function approve(ApplicationDTO $dto): DropshipperApplication
    {
        $user = auth()->user();

        if (! $user) {
            throw new Exception('User not found.');
        }

        $brand = auth()->user()->brand;
        if (! $brand) {
            throw new Exception('Brand not found.');
        }

        $application = DropshipperApplication::with(['dropshipper.user', 'brand'])->findOrFail($dto->id);
        if (! $application) {
            throw new Exception('Application not found.');
        }

        DB::beginTransaction();
        try {
            $application->update([
                'status' => Status::APPROVED,
                'notes' => $dto->notes,
                'reviewed_at' => now(),
                'reviewed_by' => auth()->id(),
            ]);
            DB::commit();

            return $application;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new Exception("Failed to submit application {$e->getMessage()}");
        }
    }

    /**
     * @throws Throwable
     */
    public static function reject(ApplicationDTO $dto): DropshipperApplication
    {
        $user = auth()->user();

        if (! $user) {
            throw new Exception('User not found.');
        }

        $brand = auth()->user()->brand;
        if (! $brand) {
            throw new Exception('Brand not found.');
        }

        $application = DropshipperApplication::with(['dropshipper.user', 'brand'])->findOrFail($dto->id);
        if (! $application) {
            throw new Exception('Application not found.');
        }

        DB::beginTransaction();
        try {
            $application->update([
                'status' => Status::REJECTED,
                'notes' => $dto->notes,
                'reviewed_at' => now(),
                'reviewed_by' => auth()->id(),
            ]);
            DB::commit();

            return $application;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new Exception("Failed to submit application {$e->getMessage()}");
        }
    }

    /**
     * @throws Throwable
     */
    public static function reapply(ApplicationDTO $dto): DropshipperApplication
    {
        $user = auth()->user();

        if (! $user) {
            throw new Exception('User not found.');
        }

        $dropshipper = auth()->user()->dropshipper;
        if (! $dropshipper) {
            throw new Exception('Dropshipper not found.');
        }

        $application = DropshipperApplication::with(['dropshipper.user', 'brand'])->findOrFail($dto->id);
        if (! $application) {
            throw new Exception('Application not found.');
        }

        DB::beginTransaction();
        try {
            $application->update([
                'status' => Status::PENDING,
                'notes' => $dto->notes,
            ]);
            DB::commit();

            return $application;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new Exception("Failed to submit application {$e->getMessage()}");
        }
    }

    /**
     * @throws Throwable
     */
    public static function revoke(ApplicationDTO $dto): void
    {
        $user = auth()->user();

        if (! $user) {
            throw new Exception('User not found.');
        }

        $brand = auth()->user()->brand;
        if (! $brand) {
            throw new Exception('Brand not found.');
        }

        $application = DropshipperApplication::where('dropshipper_id', $dto->dropshipperId)
            ->where('brand_id', $dto->brandId);
        if (! $application) {
            throw new Exception('Application not found.');
        }

        DB::beginTransaction();
        try {
            $application->update([
                'status' => Status::REJECTED,
                'notes' => $dto->notes,
            ]);

            $store = DropshipperStore::where('dropshipper_id', $dto->dropshipperId)
                ->where('brand_id', $dto->brandId);
            if ($store) {
                $store->update([
                    'status' => Status::SUSPENDED,
                ]);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw new Exception("Failed to submit application {$e->getMessage()}");
        }
    }
}
