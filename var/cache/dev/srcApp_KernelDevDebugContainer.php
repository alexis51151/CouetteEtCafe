<?php

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.

if (\class_exists(\ContainerPTbhlIz\srcApp_KernelDevDebugContainer::class, false)) {
    // no-op
} elseif (!include __DIR__.'/ContainerPTbhlIz/srcApp_KernelDevDebugContainer.php') {
    touch(__DIR__.'/ContainerPTbhlIz.legacy');

    return;
}

if (!\class_exists(srcApp_KernelDevDebugContainer::class, false)) {
    \class_alias(\ContainerPTbhlIz\srcApp_KernelDevDebugContainer::class, srcApp_KernelDevDebugContainer::class, false);
}

return new \ContainerPTbhlIz\srcApp_KernelDevDebugContainer([
    'container.build_hash' => 'PTbhlIz',
    'container.build_id' => '027488b0',
    'container.build_time' => 1573556340,
], __DIR__.\DIRECTORY_SEPARATOR.'ContainerPTbhlIz');
