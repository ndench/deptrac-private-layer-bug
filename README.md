# A small reproducer for Deptrac ignoring private layers

A quick simple reproduction of the issue where Deptrac ignores private layers.

We have 2 deptract configuration files:

1. [deptrac-private.yaml](./deptrac-private.yaml) 
    - Configuration using the `private` parameter
    - Following [the documentation](https://qossmic.github.io/deptrac/collectors/#extra-collector-configuration)
2. [deptrac-public.yaml](./deptrac-public.yaml) 
    - Alternative configuration which achives the desired result without using the `private` parameter
    - This configuration becomes very hard to maintain when the number of layers increases

## Steps to reproduce

1. Install dependencies
   ```bash
    make vendor
    ```
2. Run Deptrac with the `deptrac-private.yaml` configuration, notice that _no errors_ are returned, we are expecting 2 errors
    ```bash
    make deptrac-private
    ```
3. Run Deptrac with the `deptrac-public.yaml` configuration, notice that _2 errors_ are returned, as expected
    ```bash
    make deptrac-public
    ```

## Suggested fix

It appears that a bug exists in [DependsOnPrivateLayer](https://github.com/qossmic/deptrac/blob/d4f13c41739d0450a2a6a91962b4739a47aa9ef5/src/Core/Analyser/EventHandler/DependsOnPrivateLayer.php).
The following change causes `make deptrac-private` to return the expected result:

```diff
public function invoke(ProcessEvent $event) : void
{
    $ruleset = $event->getResult();
    foreach ($event->dependentLayers as $dependentLayer => $isPublic) {
-       if ($event->dependerLayer === $dependentLayer && !$isPublic) {
+       if ($event->dependerLayer !== $dependentLayer && !$isPublic) {
            $this->eventHelper->addSkippableViolation($event, $ruleset, $dependentLayer, $this);
            $event->stopPropagation();
        }
    }
}
```

Additionally, we can see the logic from the [initial PR which added private collectors](https://github.com/qossmic/deptrac/pull/905/files#diff-e9502a67d3bef5407b7fb6b7c8cb17ed6c4c8940502c030d9bfc62e6126b6126)

```php
if (!$isPublic && $dependerLayer !== $dependentLayer) {
    return;
}
```

And this logic was changed from `!==` to `===` in the [PR which improved violations](https://github.com/qossmic/deptrac/pull/1105/files#diff-efa7f34c2779810259ccd7158c42347c8fa29881977c5b0c3390c13229a34493)

```php
if ($event->dependerLayer === $dependentLayer && !$isPublic) {
    $this->eventHelper->addSkippableViolation($event, $ruleset, $dependentLayer, $this);
    $event->stopPropagation();
}
```
