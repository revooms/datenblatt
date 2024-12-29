```c
using System.Collections;
using System.Collections.Generic;
using UnityEngine;

public class AlignToNavMesh : MonoBehaviour {

    public bool alignOnStart = true;

    private void Start () {
        if (alignOnStart) {
            this.Align ();
        }
    }

    public void Align () {
        UnityEngine.AI.NavMeshHit hit;

        if (UnityEngine.AI.NavMesh.SamplePosition (this.transform.position, out hit, 1000f, UnityEngine.AI.NavMesh.AllAreas)) {
            this.transform.position = hit.position;
        }

    }
}
```