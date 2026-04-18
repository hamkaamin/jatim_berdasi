<style>
    .stepper-header {
        display: flex;
        align-items: flex-start;
        margin-bottom: 1.5rem;
        padding: 0 0.5rem;
    }

    .stepper-item {
        flex: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
        position: relative;
    }

    .stepper-item:not(:last-child)::after {
        content: '';
        position: absolute;
        top: 18px;
        left: calc(50% + 22px);
        width: calc(100% - 44px);
        height: 2px;
        background: #dee2e6;
        z-index: 0;
        transition: background 0.3s;
    }

    .stepper-item.step-done:not(:last-child)::after {
        background: #28a745;
    }

    .stepper-circle {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        font-weight: 600;
        z-index: 1;
        border: 2px solid #dee2e6;
        background: #fff;
        color: #6c757d;
        transition: all 0.3s;
    }

    .stepper-item.step-active .stepper-circle {
        background: #007bff;
        border-color: #007bff;
        color: #fff;
    }

    .stepper-item.step-done .stepper-circle {
        background: #28a745;
        border-color: #28a745;
        color: #fff;
    }

    .stepper-label {
        font-size: 12px;
        margin-top: 6px;
        text-align: center;
        color: #6c757d;
        line-height: 1.3;
    }

    .stepper-item.step-active .stepper-label {
        color: #007bff;
        font-weight: 600;
    }

    .stepper-item.step-done .stepper-label {
        color: #28a745;
    }

    .stepper-progress {
        height: 5px;
        background: #e9ecef;
        border-radius: 3px;
        margin-bottom: 1.5rem;
        overflow: hidden;
    }

    .stepper-progress-bar {
        height: 100%;
        background: #007bff;
        border-radius: 3px;
        transition: width 0.4s ease;
    }

    .step-panel {
        display: none;
    }

    .step-panel.step-panel-active {
        display: block;
    }

    .stepper-nav {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 1rem;
        margin-top: 1rem;
        border-top: 1px solid #dee2e6;
    }

    .step-badge {
        display: inline-block;
        background: #e9ecef;
        color: #495057;
        font-size: 12px;
        padding: 4px 12px;
        border-radius: 20px;
    }

    .step-panel-title {
        font-size: 15px;
        font-weight: 600;
        color: #343a40;
        margin-bottom: 4px;
    }

    .step-panel-subtitle {
        font-size: 13px;
        color: #6c757d;
        margin-bottom: 1.25rem;
    }

    .step-divider {
        border: none;
        border-top: 1px solid #e9ecef;
        margin: 0 0 1.25rem 0;
    }
</style>
